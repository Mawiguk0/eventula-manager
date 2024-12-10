<?php

namespace App;

use Auth;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use QrCode;
use Settings;
use Colors;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventParticipant extends Model
{
    /**
     * The name of the table.
     *
     * @var string
     */
    protected $table = 'event_participants';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array(
        'created_at',
        'updated_at',
    );

    protected $fillable = [
        'user_id',
        'event_id',
        'ticket_id',
        'purchase_id',
        'staff',
        'free',
    ];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            if (!$model->generateQRCode()) {
                return false;
            }
            return true;
        });
        self::saved(function ($model) {
            if (Settings::isCreditEnabled() && $model->staff == 0 && $model->free == 0 && $model->signed_in == 1 && !$model->credit_applied) {
                if (Settings::getCreditRegistrationEvent() != 0 || Settings::getCreditRegistrationEvent() != null) {
                    $model->user->editCredit(Settings::getCreditRegistrationEvent(), false, 'Event ' . $model->event->name . ' Registration');
                    $model->credit_applied = true;
                }
            }
            return true;
        });
        self::deleting(function ($model) {
            if (Settings::isCreditEnabled() && $model->staff == 0 && $model->free == 0 && $model->signed_in == 1 && $model->credit_applied) {
                if (Settings::getCreditRegistrationEvent() != 0 || Settings::getCreditRegistrationEvent() != null) {
                    $model->user->editCredit(-1 * abs(Settings::getCreditRegistrationEvent()), false, 'Event ' . $model->event->name . ' De-Registration');
                }
            }
            return true;
        });
    }

    /*
     * Relationships
     */
    public function event()
    {
        return $this->belongsTo('App\Event');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function ticket()
    {
        return $this->belongsTo('App\EventTicket', 'ticket_id');
    }
    public function purchase()
    {
        return $this->belongsTo('App\Purchase', 'purchase_id');
    }
    public function tournamentParticipants()
    {
        return $this->hasMany('App\EventTournamentParticipant');
    }
    public function seat()
    {
        return $this->hasOne('App\EventSeating');
    }

    /**
     * Set Event Participant as Signed in
     * @param Boolean $bool
     */
    public function setSignIn($bool = true)
    {
        $this->signed_in = true;
        if (!$bool) {
            $this->signed_in = false;
        }
        if (!$this->save()) {
            return false;
        }
        return true;
    }

    /**
     * Get User that Assigned Ticket
     * @return User
     */
    public function getAssignedByUser()
    {
        return User::where(['id' => $this->staff_free_assigned_by])->first();
    }

    /**
     * Get User that Assigned Ticket
     * @return User
     */
    public function getGiftedByUser()
    {
        return User::where(['id' => $this->gift_sendee])->first();
    }

    /**
     * Regenerate QR Codes
     * @return Boolean
     */
    public function generateQRCode($forcenewname = false)
    {
        if (Str::startsWith(config('app.url'), ['http://', 'https://'])) {
            $ticketUrl = config('app.url') . '/tickets/retrieve/' . $this->id;
        } else {
            $ticketUrl = 'https://' . config('app.url') . '/tickets/retrieve/' . $this->id;
        }

        if (isset($this->qrcode) && $this->qrcode != "" && !$forcenewname) {
            $qrCodeFullPath = $this->qrcode;
        } else {
            $qrCodePath = 'storage/images/events/' . $this->event->slug . '/qr/';
            $qrCodeFileName =  $this->event->slug . '-' . Str::random(32) . '.png';
            if (!file_exists($qrCodePath)) {
                mkdir($qrCodePath, 0775, true);
            }
            $qrCodeFullPath = $qrCodePath . $qrCodeFileName;
        }

        QrCode::format('png')->size(300)->margin(1)->generate($ticketUrl, $qrCodeFullPath);
        $this->qrcode = $qrCodeFullPath;

        if (!$this->save()) {
            return false;
        }
        return true;
    }

    /**
     * Transfer Participant to another Event
     * @param $type
     * @return Orders
     */
    public function transfer($eventId)
    {
        $this->transferred = true;
        $this->transferred_event_id = $this->event_id;
        $this->event_id = $eventId;
        if (!$this->save()) {
            return false;
        }
        return true;
    }

    /**
     * Get New Participants
     * @param $type
     * @return EventParticipant
     */
    public static function getNewParticipants($type = 'all')
    {
        if (!$user = Auth::user()) {
            $type = 'all';
        }
        switch ($type) {
            case 'login':
                $particpants = self::where('created_at', '>=', $user->last_login)->get();
                break;
            default:
                $particpants = self::where('created_at', '>=', date('now - 1 day'))->get();
                break;
        }
        return $particpants;
    }

    public function getPdf(): string
    {
        $user = Auth::user();
        $data = new \stdClass();
        // TODO: Probably don't use str_replace
        $qrfile = base64_encode(\Storage::read(str_replace('storage', 'public', $this->qrcode)));
        $now = Carbon::now();

        if ($this->ticket) {
            $data->ticket_name = $this->ticket->name;
        } elseif ($this->staff) {
            $data->ticket_name = __('tickets.staff_ticket');
        } else {
            $data->ticket_name = __('tickets.free_ticket');
        }

        if ($this->seat) {
            $data->seat = $this->seat->getName();
            $data->seating_plan = $this->seat->seatingPlan->name;
        } else {
            $data->seat = __('events.notseated');
            $data->seating_plan = $data->seat;
        }

        $data->qr_image = "data:image/png;base64,{$qrfile}";
        $data->event_name = $this->event->display_name;
        $data->firstname = $user->firstname;
        $data->surname = $user->surname;
        $data->username = $user->username;
        $data->date = $now->toDateString();    //TODO: Date/time format does not seem to heed locale
        $data->time = $now->toTimeString();


        $pdfView = view('ticket.pdf')
            ->with('data', $data)
            ->render();

        $pdf = new Dompdf();
        $pdf->setPaper('A4', 'portrait');
        $pdf->loadHtml($pdfView);
        $pdf->render();

        return $pdf->output();
    }

    function setRevoked()
    {
        $this->revoked = true;
        if (!$this->seat) {
            return $this->save();
        }
        if (!$this->seat->delete() || !$this->setSignIn(false)) {
            $this->revoked = false;
            return false;
        }
        return $this->save();
    }

    /**
     * Check if participant is active
     * @return Boolean
     */
    public function isActive()
    {

        return ($this->signed_in || $this->event->online_event) &&
            ($this->free || $this->staff || $this->purchase->status == "Success") &&
            (!$this->revoked);
    }
}
