<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Dashboard</h2>
    <small class="text-muted">Bem-vindo, <?php echo e(session('user_name')); ?></small>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-secondary">
            <div class="card-body text-center">
                <h1 class="display-5"><?php echo e($totalOrders->total); ?></h1>
                <p class="text-muted mb-0">Total de OS</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-secondary">
            <div class="card-body text-center">
                <h1 class="display-5 text-warning"><?php echo e($ordersAwaitingApproval->total); ?></h1>
                <p class="text-muted mb-0">Aguardando Aprovação</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-secondary">
            <div class="card-body text-center">
                <h1 class="display-5 text-primary"><?php echo e($ordersInRepair->total); ?></h1>
                <p class="text-muted mb-0">Em Reparo</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-secondary">
            <div class="card-body text-center">
                <h1 class="display-5 text-success"><?php echo e($ordersReady->total); ?></h1>
                <p class="text-muted mb-0">Prontos para Entrega</p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card border-secondary">
            <div class="card-body text-center">
                <h2><?php echo e($totalCustomers->total); ?></h2>
                <p class="text-muted mb-0">Clientes Cadastrados</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card border-secondary">
            <div class="card-body text-center">
                <h2><?php echo e($totalVehicles->total); ?></h2>
                <p class="text-muted mb-0">Veículos Cadastrados</p>
            </div>
        </div>
    </div>
</div>

<div class="row">

    
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header bg-light">
                <strong>Últimas Ordens de Serviço</strong>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>OS #</th>
                            <th>Veículo</th>
                            <th>Cliente</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($order->id); ?></td>
                            <td><?php echo e($order->license_plate); ?> - <?php echo e($order->brand); ?> <?php echo e($order->model); ?></td>
                            <td><?php echo e($order->customer_name); ?></td>
                            <td>
                                
                                <?php switch($order->status):
                                    case ('received'): ?> <span class="badge bg-secondary">Recebido</span> <?php break; ?>
                                    <?php case ('diagnostic'): ?> <span class="badge bg-primary">Diagnóstico</span> <?php break; ?>
                                    <?php case ('awaiting_approval'): ?> <span class="badge bg-warning text-dark">Aguard. Aprovação</span> <?php break; ?>
                                    <?php case ('in_repair'): ?> <span class="badge bg-warning text-dark">Em Reparo</span> <?php break; ?>
                                    <?php case ('ready'): ?> <span class="badge bg-success">Pronto</span> <?php break; ?>
                                    <?php case ('delivered'): ?> <span class="badge bg-dark">Entregue</span> <?php break; ?>
                                <?php endswitch; ?>
                            </td>
                            <td><?php echo e(date('d/m/Y', strtotime($order->opened_at))); ?></td>
                            <td>
                                <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="btn btn-sm btn-outline-secondary">Ver</a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">Nenhuma ordem de serviço cadastrada ainda.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white">
                <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-sm btn-outline-dark">Ver todas as OS</a>
            </div>
        </div>
    </div>

    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-light">
                <strong><img src="/icons/alert.png" alt="Atenção" width="24" height="24" style="width:24px;height:24px;max-width:24px;vertical-align:middle;object-fit:contain;"> Estoque Baixo</strong>
                <small class="text-muted">(menos de 5 unidades)</small>
            </div>
            <div class="card-body p-0">
                <?php $__empty_1 = true; $__currentLoopData = $lowStockParts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
                    <span class="small"><?php echo e($part->name); ?></span>
                    <span class="badge bg-danger"><?php echo e($part->stock_quantity); ?> un.</span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="p-3 text-center text-muted">
                    <small>Estoque OK - Nenhum item crítico.</small>
                </div>
                <?php endif; ?>
            </div>
            <?php if(count($lowStockParts) > 0): ?>
            <div class="card-footer bg-white">
                <a href="<?php echo e(route('parts.index')); ?>" class="btn btn-sm btn-outline-danger">Ver estoque</a>
            </div>
            <?php endif; ?>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php  ?>