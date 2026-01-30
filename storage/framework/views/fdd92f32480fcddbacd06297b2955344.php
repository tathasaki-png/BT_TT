

<?php $__env->startSection('title', 'Thống kê doanh thu'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Thống Kê Doanh Thu</h1>
        <p class="page-subtitle">Báo cáo doanh thu chi tiết theo phương thức thanh toán.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Total Revenue -->
    <div class="col-md-4">
        <div class="stats-card">
            <div class="stats-icon primary">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stats-value"><?php echo e(number_format($totalRevenue)); ?> VND</div>
            <div class="stats-label">Tổng Doanh Thu</div>
        </div>
    </div>
    <!-- VNPay Revenue -->
    <div class="col-md-4">
        <div class="stats-card">
            <div class="stats-icon info">
                <i class="fas fa-credit-card"></i>
            </div>
            <div class="stats-value text-info"><?php echo e(number_format($revenueVNPay)); ?> VND</div>
            <div class="stats-label">Doanh Thu VNPay</div>
        </div>
    </div>
    <!-- COD Revenue -->
    <div class="col-md-4">
        <div class="stats-card">
            <div class="stats-icon warning">
                <i class="fas fa-truck"></i>
            </div>
            <div class="stats-value text-warning"><?php echo e(number_format($revenueCOD)); ?> VND</div>
            <div class="stats-label">Doanh Thu COD</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Revenue Chart -->
    <div class="col-lg-12">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Biểu đồ doanh thu 30 ngày gần đây</h5>
            </div>
            <div class="card-body">
                <div style="height: 400px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Distribution Pie Chart -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tỷ lệ đơn hàng theo phương thức</h5>
            </div>
            <div class="card-body d-flex justify-content-center">
                <div style="height: 300px; width: 300px;">
                    <canvas id="distributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Table -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">Chi tiết doanh thu</h5>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Phương thức</th>
                            <th>Tổng doanh thu</th>
                            <th>Tỷ lệ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><i class="fas fa-credit-card text-info me-2"></i>VNPay</td>
                            <td class="fw-bold"><?php echo e(number_format($revenueVNPay)); ?> VND</td>
                            <td><?php echo e($totalRevenue > 0 ? round(($revenueVNPay / $totalRevenue) * 100, 1) : 0); ?>%</td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-truck text-warning me-2"></i>COD</td>
                            <td class="fw-bold"><?php echo e(number_format($revenueCOD)); ?> VND</td>
                            <td><?php echo e($totalRevenue > 0 ? round(($revenueCOD / $totalRevenue) * 100, 1) : 0); ?>%</td>
                        </tr>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th class="fw-bold">Tổng cộng</th>
                            <th class="fw-bold"><?php echo e(number_format($totalRevenue)); ?> VND</th>
                            <th class="fw-bold">100%</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const labels = <?php echo json_encode($chartData['labels']); ?>;
        const codData = <?php echo json_encode($chartData['cod']); ?>;
        const vnpayData = <?php echo json_encode($chartData['vnpay']); ?>;
        const totalData = <?php echo json_encode($chartData['total']); ?>;

        // Line Chart for daily revenue
        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Tổng doanh thu',
                        data: totalData,
                        borderColor: '#16a34a',
                        backgroundColor: 'rgba(22, 163, 74, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Doanh thu VNPay',
                        data: vnpayData,
                        borderColor: '#3b82f6',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        tension: 0.3
                    },
                    {
                        label: 'Doanh thu COD',
                        data: codData,
                        borderColor: '#f59e0b',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString() + ' đ';
                            }
                        }
                    }
                }
            }
        });

        // Pie Chart for distribution
        new Chart(document.getElementById('distributionChart'), {
            type: 'doughnut',
            data: {
                labels: ['VNPay', 'COD'],
                datasets: [{
                    data: [<?php echo e($revenueVNPay); ?>, <?php echo e($revenueCOD); ?>],
                    backgroundColor: ['#3b82f6', '#f59e0b'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\TTS\khoahoc\resources\views/admin/revenue/index.blade.php ENDPATH**/ ?>