<!DOCTYPE html>
<html>
<head>
    <title>{{ ucfirst($type) }} User Report</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h2>{{ ucfirst($type) }} User Report</h2>

    <table>
        <thead>
            <tr>
                @foreach($data->first()->getAttributes() as $key => $val)
                    <th>{{ ucfirst($key) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $user)
                <tr>
                    @foreach($user->getAttributes() as $val)
                        <td>{{ $val }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
