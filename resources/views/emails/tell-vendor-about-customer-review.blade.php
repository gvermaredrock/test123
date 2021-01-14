@component('mail::message')
# Review Posted by a verified user

A Wuchna.com verified user just posted a review / enquiry about your business.

You can:

@component('mail::button', ['url' => $listing->full_link.'#reviews'])
See Client Review / Enquiry
@endcomponent
OR
@component('mail::button', ['url' => config('my.APP_URL').'/managecomments'])
    Post your reply
@endcomponent

For any further information / enquiries, just reply back to this email.

Thanks,<br>
Wuchna Business Network
@endcomponent
