<x-mail::message>
# Message received

We will respond as soon as possible.

<x-mail::table>
| Name |
| :--- |
| {{ $msg->name }} |
</x-mail::table>

<x-mail::table>
| Email | Phone |
| :--- | :--- |
| {{ $msg->email }} | {{ $msg->phone ?? 'N/A' }} |
</x-mail::table>

**Message:**
<x-mail::panel>
{{ $msg->message }}
</x-mail::panel>

Thank you,<br>
{{ config('app.name') }}
</x-mail::message>