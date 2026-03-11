<?php $__env->startSection('title', 'Veículos'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Veículos</h2>
    <?php if(in_array(session('user_role'), ['manager', 'attendant'])): ?>
    <a href="<?php echo e(route('vehicles.create')); ?>" class="btn btn-dark">+ Novo Veículo</a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Placa</th>
                    <th>Marca / Modelo</th>
                    <th>Código FIPE</th>
                    <th>Proprietário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($vehicle->id); ?></td>
                    <td><strong><?php echo e($vehicle->license_plate); ?></strong></td>
                    <td><?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?></td>
                    <td><?php echo e($vehicle->fipe_code ?? '-'); ?></td>
                    <td><?php echo e($vehicle->customer_name); ?></td>
                    <td>
                        <a href="<?php echo e(route('vehicles.show', $vehicle->id)); ?>" class="btn btn-sm btn-outline-secondary">Ver histórico</a>
                        <?php if(in_array(session('user_role'), ['manager', 'attendant'])): ?>
                        <a href="<?php echo e(route('vehicles.edit', $vehicle->id)); ?>" class="btn btn-sm btn-outline-secondary">Editar</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Nenhum veículo cadastrado.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php  ?>