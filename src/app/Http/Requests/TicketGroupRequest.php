<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Assuming authorization logic, you may need to adjust this based on your requirements
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ticket-group-name' => 'required',
            'ticket-group-tickets' => 'required|numeric',
        ];
    }

    /**
     * Get custom error messages for validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'ticket-group-name.required' => 'Ticket group name is required',
            'ticket-group-tickets.numeric' => 'Tickets per user must be a number',
            'ticket-group-tickets.required' => 'Tickets per user is required',
        ];
    }
}
