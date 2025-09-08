<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 0; }
        .container { background-color: #fff; width: 90%; max-width: 600px; margin: 30px auto; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h2 { color: #800000; }
        p { font-size: 16px; color: #333; line-height: 1.5; }
        .details { margin-top: 20px; }
        .details th, .details td { text-align: left; padding: 8px; }
        .details th { color: #800000; }
        .footer { margin-top: 30px; font-size: 14px; color: #777; text-align: center; }
        .badge { display: inline-block; padding: 5px 10px; border-radius: 5px; color: #fff; font-weight: bold; }
        .pending { background-color: #f0ad4e; }
        .approved { background-color: #28a745; }
        .rejected { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Appointment Confirmation</h2>
        <p>Hi {{ $student->name }},</p>
        <p>Your appointment with counselor <strong>{{ $counselor->name }}</strong> has been successfully scheduled. Below are the details:</p>

        <table class="details">
            <tr>
                <th>Student:</th>
                <td>{{ $student->name }}</td>
            </tr>
            <tr>
                <th>Counselor:</th>
                <td>{{ $counselor->name }}</td>
            </tr>
            <tr>
                <th>Date:</th>
                <td>{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</td>
            </tr>
            <tr>
                <th>Time:</th>
                <td>{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
            </tr>
            <tr>
                <th>Status:</th>
                <td>
                    <span class="badge {{ strtolower($appointment->status) }}">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </td>
            </tr>
            <tr>
                <th>Reason:</th>
                <td>{{ $appointment->reason }}</td>
            </tr>
        </table>

        <p>Please make sure to be on time for your appointment.</p>

        <div class="footer">
            <p>LCSHS Student Counseling Management System</p>
        </div>
    </div>
</body>
</html>
