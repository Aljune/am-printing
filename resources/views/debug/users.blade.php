<!DOCTYPE html>
<html>
<head>
    <title>Users - Debug</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; padding: 40px 20px; background: #f5f7fa; }
        .container { max-width: 1200px; margin: 0 auto; }
        .header { background: #2c3e50; color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .warning { background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px 20px; margin-bottom: 20px; border-radius: 4px; }
        .warning strong { color: #856404; }
        table { width: 100%; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        th { background: #34495e; color: white; padding: 15px; text-align: left; font-weight: 600; }
        td { padding: 12px 15px; border-bottom: 1px solid #ecf0f1; }
        tr:hover { background: #f8f9fa; }
        .password { font-family: 'Courier New', monospace; font-size: 12px; background: #f0f0f0; padding: 4px 8px; border-radius: 4px; word-break: break-all; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 12px; }
        .badge-yes { background: #d4edda; color: #155724; }
        .badge-no { background: #f8d7da; color: #721c24; }
        .count { background: #3498db; color: white; padding: 8px 16px; border-radius: 20px; display: inline-block; margin-top: 10px; }
        .footer { margin-top: 20px; color: #7f8c8d; text-align: center; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 User Database</h1>
            <p>All users with hashed passwords (for debugging only)</p>
        </div>
        
        <div class="warning">
            <strong>⚠️ WARNING:</strong> This page shows hashed passwords. 
            <strong>REMOVE THIS ROUTE BEFORE PRODUCTION!</strong>
        </div>
        
        <div>
            <span class="count">👥 Total Users: {{ $users->count() }}</span>
        </div>
        
        <br>
        
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password (Hashed)</th>
                    <th>Verified</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td><span class="password">{{ $user->password }}</span></td>
                    <td>
                        @if($user->email_verified_at)
                            <span class="badge badge-yes">✅ Verified</span>
                        @else
                            <span class="badge badge-no">❌ Not verified</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at ? $user->created_at->format('Y-m-d H:i') : 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="footer">
            <p>💡 Passwords are stored as bcrypt hashes. This is not the actual plain-text password.</p>
            <p>🛑 Remove this route before deploying to production!</p>
        </div>
    </div>
</body>
</html>