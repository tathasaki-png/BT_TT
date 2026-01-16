<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Logs - Queue & Mail</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
        }
        
        .navbar {
            background: white;
            padding: 15px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .navbar h1 {
            font-size: 20px;
            color: #667eea;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .section h2 {
            margin-bottom: 15px;
            font-size: 18px;
            color: #667eea;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .stat-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
        }
        
        .stat-box .number {
            font-size: 28px;
            font-weight: bold;
            margin: 5px 0;
        }
        
        .stat-box .label {
            font-size: 12px;
            opacity: 0.9;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table th {
            background: #f5f7fa;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #eee;
            font-size: 13px;
        }
        
        table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 13px;
        }
        
        table tr:hover {
            background: #f9f9f9;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .badge-success {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }
        
        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-info {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            font-size: 12px;
            background: #667eea;
            color: white;
            transition: all 0.3s;
        }
        
        .btn:hover {
            background: #5568d3;
        }
        
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        
        .pagination a, .pagination span {
            padding: 8px 12px;
            margin: 0 2px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #667eea;
        }
        
        .pagination .active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }
        
        .pagination a:hover {
            background: #f0f0f0;
        }
        
        .empty {
            text-align: center;
            color: #999;
            padding: 30px;
        }
        
        .back-link {
            display: inline-block;
            margin-bottom: 15px;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>📋 Nhật Ký Công Việc Queue</h1>
    </div>
    
    <div class="container">
        <a href="/dashboard" class="back-link">← Quay lại Dashboard</a>
        
        <!-- Statistics -->
        <div class="section">
            <h2>📊 Thống Kê</h2>
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="label">Tổng Cộng</div>
                    <div class="number">{{ \App\Models\JobLog::count() }}</div>
                </div>
                <div class="stat-box">
                    <div class="label">Thành Công</div>
                    <div class="number">{{ \App\Models\JobLog::success()->count() }}</div>
                </div>
                <div class="stat-box">
                    <div class="label">Thất Bại</div>
                    <div class="number">{{ \App\Models\JobLog::failed()->count() }}</div>
                </div>
            </div>
        </div>
        
        <!-- Job Logs Table -->
        <div class="section">
            <h2>📝 Lịch Sử Gửi Email</h2>
            
            @if($logs->count() > 0)
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Công Việc</th>
                                <th>Trạng Thái</th>
                                <th>Lần Thử</th>
                                <th>Bắt Đầu</th>
                                <th>Kết Thúc</th>
                                <th>Lỗi</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>{{ $log->email }}</td>
                                    <td>
                                        <span style="font-family: monospace; font-size: 11px; background: #f0f0f0; padding: 2px 6px; border-radius: 3px;">
                                            {{ class_basename($log->job_name) }}
                                        </span>
                                    </td>
                                    <td>
                                        @switch($log->status)
                                            @case('success')
                                                <span class="badge badge-success">✓ Thành công</span>
                                                @break
                                            @case('failed')
                                                <span class="badge badge-danger">✗ Thất bại</span>
                                                @break
                                            @case('processing')
                                                <span class="badge badge-warning">⚙ Đang xử lý</span>
                                                @break
                                            @default
                                                <span class="badge badge-info">○ Chờ</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $log->retry_count }}/{{ $log->max_retries }}</td>
                                    <td>
                                        {{ $log->started_at ? $log->started_at->format('d/m/Y H:i:s') : '-' }}
                                    </td>
                                    <td>
                                        {{ $log->completed_at ? $log->completed_at->format('d/m/Y H:i:s') : '-' }}
                                    </td>
                                    <td>
                                        @if($log->error_message)
                                            <button class="btn" onclick="alert('{{ addslashes($log->error_message) }}')">
                                                Xem
                                            </button>
                                        @else
                                            <span style="color: #999;">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form method="POST" action="/dashboard/delete-user/{{ urlencode($log->email) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn" style="background: #e74c3c;" onclick="return confirm('Xóa user {{ $log->email }} và tất cả logs liên quan?')">
                                                🗑️
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="pagination">
                    {{ $logs->links() }}
                </div>
            @else
                <div class="empty">
                    <p>Chưa có nhật ký nào.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
