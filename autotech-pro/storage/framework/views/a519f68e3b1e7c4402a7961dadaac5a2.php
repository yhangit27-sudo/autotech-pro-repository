<?php $__env->startSection('title', 'Ordens de Serviço'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Ordens de Serviço</h2>
    <?php if(in_array(session('user_role'), ['manager', 'attendant'])): ?>
    <a href="<?php echo e(route('orders.create')); ?>" class="btn btn-dark">+ Abrir Nova OS</a>
    <?php endif; ?>
</div>

<div class="mb-3">
    <small class="text-muted">Filtrar por status:</small>
    <a href="<?php echo e(route('orders.index')); ?>" class="badge bg-secondary text-decoration-none ms-1">Todos</a>
    <a href="<?php echo e(route('orders.index')); ?>?status=received" class="badge bg-secondary text-decoration-none ms-1">Recebidos</a>
    <a href="<?php echo e(route('orders.index')); ?>?status=diagnostic" class="badge bg-primary text-decoration-none ms-1">Diagnóstico</a>
    <a href="<?php echo e(route('orders.index')); ?>?status=awaiting_approval" class="badge bg-warning text-dark text-decoration-none ms-1">Aguard. Aprovação</a>
    <a href="<?php echo e(route('orders.index')); ?>?status=in_repair" class="badge bg-warning text-dark text-decoration-none ms-1">Em Reparo</a>
    <a href="<?php echo e(route('orders.index')); ?>?status=ready" class="badge bg-success text-decoration-none ms-1">Prontos</a>
    <a href="<?php echo e(route('orders.index')); ?>?status=delivered" class="badge bg-dark text-decoration-none ms-1">Entregues</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>OS #</th>
                    <th>Veículo</th>
                    <th>Cliente</th>
                    <th>Atendente</th>
                    <th>Status</th>
                    <th>Abertura</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><strong>#<?php echo e($order->id); ?></strong></td>
                    <td><?php echo e($order->license_plate); ?><br><small class="text-muted"><?php echo e($order->brand); ?> <?php echo e($order->model); ?></small></td>
                    <td><?php echo e($order->customer_name); ?></td>
                    <td><?php echo e($order->attendant_name); ?></td>
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
                    <td><?php echo e(date('d/m/Y H:i', strtotime($order->opened_at))); ?></td>
                    <td>
                        <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="btn btn-sm btn-outline-secondary">Ver</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Nenhuma ordem de serviço encontrada.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php  ?>