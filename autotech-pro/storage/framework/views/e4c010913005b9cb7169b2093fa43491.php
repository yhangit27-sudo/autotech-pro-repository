<?php $__env->startSection('title', 'Catálogo de Serviços'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Catálogo de Serviços</h2>
    <?php if(in_array(session('user_role'), ['manager', 'attendant'])): ?>
    <a href="<?php echo e(route('services.create')); ?>" class="btn btn-dark">+ Novo Serviço</a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Descrição do Serviço</th>
                    <th>Valor por Hora (R$)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($service->id); ?></td>
                    <td><?php echo e($service->description); ?></td>
                    <td>R$ <?php echo e(number_format($service->hourly_rate, 2, ',', '.')); ?>/h</td>
                    <td>
                        <?php if(in_array(session('user_role'), ['manager', 'attendant'])): ?>
                        <a href="<?php echo e(route('services.edit', $service->id)); ?>" class="btn btn-sm btn-outline-secondary">Editar</a>
                        <?php endif; ?>
                        <?php if(session('user_role') === 'manager'): ?>
                        <form method="POST" action="<?php echo e(route('services.destroy', $service->id)); ?>" style="display:inline;"
                              onsubmit="return confirm('Remover este serviço?')">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">Nenhum serviço cadastrado no catálogo.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php  ?>