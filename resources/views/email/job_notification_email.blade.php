<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Notification</title>
</head>

<body>
    <h1>Dear {{ $mailData['employer']->name }}</h1>
    <h2>Job title: {{ $mailData['job']->title }}</h2>
    <h2>Employer Details: {{ $mailData['user']->name }}</h2>
    <h2>Email: {{ $mailData['user']->email }}</h2>
    <h2>Mobile: {{ $mailData['user']->mobile }}</h2>
</body>

</html>
