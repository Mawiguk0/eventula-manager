@if (!$event->sponsors->isEmpty())
    <div class="pb-2 mt-4 mb-4 border-bottom">
        <a name="sponsors"></a>
        <h3><i class="fas fa-running mr-3"></i>@lang('events.eventsponsoredby', ['event' => $event->display_name])</h3>
    </div>
    <div class="row justify-content-center">
        @foreach ($event->sponsors as $sponsor)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100 d-flex flex-column align-items-center justify-content-center">
                    <a href="{{ $sponsor->website }}" class="text-decoration-none d-flex flex-column align-items-center justify-content-center h-100">
                        <picture class="d-flex align-items-center justify-content-center p-3" style="border: 1px solid #ddd; border-radius: 4px; width: 100%; height: 200px;">
                            <source srcset="{{ $sponsor->image_path }}.webp" type="image/webp">
                            <source srcset="{{ $sponsor->image_path }}" type="image/jpeg">
                            <img src="{{ $sponsor->image_path }}" alt="{{ $sponsor->name }}" class="img-fluid" style="max-width: 100%; max-height: 100%; object-fit: contain;"/>
                        </picture>

                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endif
