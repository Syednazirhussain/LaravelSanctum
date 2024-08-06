<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h2>User Information</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($users))                
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone && $user->phone->user_id ? $user->phone->code.' '.$user->phone->number: '' }}</td>
                        <td>{{ $user->address && $user->address->user_id ? $user->address->line_address_1.','.$user->address->city.','.$user->address->state.','.$user->address->country: '' }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>
</html>
