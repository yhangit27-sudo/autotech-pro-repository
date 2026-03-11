<?php $__env->startSection('title', 'Peças / Estoque'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Peças / Estoque</h2>
    <?php if(in_array(session('user_role'), ['manager', 'attendant'])): ?>
    <a href="<?php echo e(route('parts.create')); ?>" class="btn btn-dark">+ Nova Peça</a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nome da Peça</th>
                    <th>Preço de Custo</th>
                    <th>Preço de Venda</th>
                    <th>Margem</th>
                    <th>Qtd. Estoque</th>
                    <th>Garantia Fabricante</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($part->id); ?></td>
                    <td><?php echo e($part->name); ?></td>
                    <td>R$ <?php echo e(number_format($part->cost_price, 2, ',', '.')); ?></td>
                    <td>R$ <?php echo e(number_format($part->sale_price, 2, ',', '.')); ?></td>
                    <td>
                        
                        <?php
                            $margem = (($part->sale_price - $part->cost_price) / $part->cost_price) * 100;
                        ?>
                        <?php echo e(number_format($margem, 1)); ?>%
                    </td>
                    <td>
                        
                        <?php if($part->stock_quantity < 5): ?>
                            <span class="badge bg-danger"><?php echo e($part->stock_quantity); ?></span>
                        <?php elseif($part->stock_quantity < 10): ?>
                            <span class="badge bg-warning text-dark"><?php echo e($part->stock_quantity); ?></span>
                        <?php else: ?>
                            <span class="badge bg-secondary"><?php echo e($part->stock_quantity); ?></span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($part->manufacturer_warranty_months); ?> meses</td>
                    <td>
                        <?php if(in_array(session('user_role'), ['manager', 'attendant'])): ?>
                        <a href="<?php echo e(route('parts.edit', $part->id)); ?>" class="btn btn-sm btn-outline-secondary">Editar</a>
                        <?php endif; ?>
                        <?php if(session('user_role') === 'manager'): ?>
                        <form method="POST" action="<?php echo e(route('parts.destroy', $part->id)); ?>" style="display:inline;"
                              onsubmit="return confirm('Remover esta peça do estoque?')">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Nenhuma peça cadastrada no estoque.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php  ?>