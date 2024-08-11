<!DOCTYPE html>
<html>

<head>
    <title>Consultation Scheduled</title>
</head>

<body>
    <h1>Your Consultation has been Scheduled</h1>
    <p>Dear {{ $consultation->user->name }},</p>
    <p>Your consultation with {{ $consultation->professional->name }} has been scheduled for {{ $consultation->scheduled_at }}.</p>
    <p>Notes: {{ $consultation->notes }}</p>
    <p>Thank you for using our service!</p>
</body>

</html>