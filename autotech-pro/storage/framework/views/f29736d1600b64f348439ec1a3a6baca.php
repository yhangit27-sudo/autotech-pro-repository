

<?php $__env->startSection('title', 'Usuários'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .user-card { background: var(--preto-secundario); border: 1px solid #2a2a2a; border-radius: 8px; overflow: hidden; }
    .table-dark { --bs-table-bg: transparent; --bs-table-color: var(--branco); --bs-table-border-color: #2a2a2a; }
    .thead-custom { background: #1a1a1a; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; color: var(--cinza-medio); }
    .btn-marca { background: var(--vermelho-principal); color: white; border: none; }
    .btn-marca:hover { background: var(--vermelho-claro); color: white; }
    
    /* Badges de Cargos */
    .badge-manager { background-color: #ff4d4d; color: white; } /* Vermelho Vibrante */
    .badge-attendant { background-color: #3498db; color: white; } /* Azul */
    .badge-mechanic { background-color: #f1c40f; color: #000; } /* Amarelo */
    .badge-customer { background-color: transparent; border: 1px solid #444; color: #aaa; } /* Discreto */
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="d-flex align-items-center gap-2 mb-0 text-white">
        <i data-lucide="users" class="text-danger"></i> Gestão de <span class="text-danger">Usuários</span>
    </h2>
    <a href="<?php echo e(route('users.create')); ?>" class="btn btn-marca d-inline-flex align-items-center gap-2 px-3 shadow-sm">
        <i data-lucide="user-plus" class="size-5"></i> Novo Usuário
    </a>
</div>

<div class="card user-card shadow-lg">
    <div class="card-body p-0 table-responsive">
        <table class="table table-dark table-hover mb-0 align-middle">
            <thead class="thead-custom">
                <tr>
                    <th class="ps-4 py-3 border-0">Usuário</th>
                    <th class="py-3 border-0">Documento</th>
                    <th class="py-3 border-0 text-center">Cargo</th>
                    <th class="py-3 border-0 text-center">Cadastro</th>
                    <th class="pe-4 py-3 border-0 text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="ps-4">
                        <div class="text-white fw-bold"><?php echo e($user->full_name); ?></div>
                        <small class="text-muted"><?php echo e($user->email); ?></small>
                    </td>
                    <td class="text-muted font-monospace small">
                        <?php echo e($user->tax_id); ?>

                    </td>
                    <td class="text-center">
                        <?php switch($user->role):
                            case ('manager'): ?> <span class="badge badge-manager">Gerente</span> <?php break; ?>
                            <?php case ('attendant'): ?> <span class="badge badge-attendant">Atendente</span> <?php break; ?>
                            <?php case ('mechanic'): ?> <span class="badge badge-mechanic">Mecânico</span> <?php break; ?>
                            <?php case ('customer'): ?> <span class="badge badge-customer">Cliente</span> <?php break; ?>
                        <?php endswitch; ?>
                    </td>
                    <td class="text-center text-muted small">
                        <?php echo e(date('d/m/Y', strtotime($user->created_at))); ?>

                    </td>
                    <td class="pe-4 text-end">
                        <div class="d-flex justify-content-end gap-1">
                            <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="btn btn-sm btn-outline-light border-0" title="Editar">
                                <i data-lucide="user-cog" class="size-4"></i>
                            </a>

                            <?php if($user->id != session('user_id')): ?>
                            <form method="POST" action="<?php echo e(route('users.destroy', $user->id)); ?>" class="d-inline" onsubmit="return confirm('Deseja remover este acesso?')">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Excluir">
                                    <i data-lucide="user-x" class="size-4"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center text-muted py-5">
                        <i data-lucide="shield-alert" class="size-10 opacity-25 mb-2"></i>
                        <p>Nenhum usuário encontrado.</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\icro\autotech-pro-repository\autotech-pro\resources\views/users/index.blade.php ENDPATH**/ ?>