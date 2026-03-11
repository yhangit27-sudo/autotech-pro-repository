<?php $__env->startSection('title', 'Usuários'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Usuários do Sistema</h2>
    <a href="<?php echo e(route('users.create')); ?>" class="btn btn-dark">+ Novo Usuário</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nome Completo</th>
                    <th>E-mail</th>
                    <th>CPF/CNPJ</th>
                    <th>Cargo</th>
                    <th>Cadastrado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($user->id); ?></td>
                    <td><?php echo e($user->full_name); ?></td>
                    <td><?php echo e($user->email); ?></td>
                    <td><?php echo e($user->tax_id); ?></td>
                    <td>
                        <?php switch($user->role):
                            case ('manager'): ?> <span class="badge bg-dark">Gerente</span> <?php break; ?>
                            <?php case ('attendant'): ?> <span class="badge bg-secondary">Atendente</span> <?php break; ?>
                            <?php case ('mechanic'): ?> <span class="badge bg-secondary">Mecânico</span> <?php break; ?>
                            <?php case ('customer'): ?> <span class="badge bg-light text-dark border">Cliente</span> <?php break; ?>
                        <?php endswitch; ?>
                    </td>
                    <td><?php echo e(date('d/m/Y', strtotime($user->created_at))); ?></td>
                    <td>
                        <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="btn btn-sm btn-outline-secondary">Editar</a>

                        
                        <?php if($user->id != session('user_id')): ?>
                        <form method="POST" action="<?php echo e(route('users.destroy', $user->id)); ?>" style="display:inline;"
                              onsubmit="return confirm('Tem certeza que deseja remover este usuário?')">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Nenhum usuário cadastrado.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php  ?>