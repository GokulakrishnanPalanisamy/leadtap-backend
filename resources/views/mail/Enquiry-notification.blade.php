<!DOCTYPE html>
<html>
<head>
    <title>Enquiry Received</title>
</head>
<body>

<h2>Hello {{ $enquiry->name }}</h2>

<p>
    Thank you for your enquiry regarding property
</p>

<p><strong>Name:</strong> {{ $enquiry->name }}</p>
<p><strong>Email:</strong> {{ $enquiry->email }}</p>
<p><strong>Phone:</strong> {{ $enquiry->phone }}</p>
<p><strong>Message:</strong></p>

<p>{{ $enquiry->message }}</p>

<br>

<p>
    Our team will contact you shortly.
</p>

<p>
    Regards,<br>
    LeadTap Team
</p>

</body>
</html>
