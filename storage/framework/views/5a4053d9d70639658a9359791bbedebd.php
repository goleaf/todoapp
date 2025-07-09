<?php if (isset($component)) { $__componentOriginal63025df94105f25d292e3d74a8fd1c9c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal63025df94105f25d292e3d74a8fd1c9c = $attributes; } ?>
<?php $component = App\View\Components\Layout\Auth::resolve(['title' => __('auth.log_in')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout.auth'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layout\Auth::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php if (isset($component)) { $__componentOriginalf43ca188c32529b665e1efb6682b9827 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf43ca188c32529b665e1efb6682b9827 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth.auth-header','data' => ['title' => __('auth.log_in_to_account'),'description' => __('auth.enter_credentials')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth.auth-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('auth.log_in_to_account')),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('auth.enter_credentials'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf43ca188c32529b665e1efb6682b9827)): ?>
<?php $attributes = $__attributesOriginalf43ca188c32529b665e1efb6682b9827; ?>
<?php unset($__attributesOriginalf43ca188c32529b665e1efb6682b9827); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf43ca188c32529b665e1efb6682b9827)): ?>
<?php $component = $__componentOriginalf43ca188c32529b665e1efb6682b9827; ?>
<?php unset($__componentOriginalf43ca188c32529b665e1efb6682b9827); ?>
<?php endif; ?>

    <div class="mt-6">
        <?php if (isset($component)) { $__componentOriginalb65f01a71cfb9e224e52830349944788 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb65f01a71cfb9e224e52830349944788 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth.auth-session-status','data' => ['class' => 'text-center','status' => session('status')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth.auth-session-status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-center','status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(session('status'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb65f01a71cfb9e224e52830349944788)): ?>
<?php $attributes = $__attributesOriginalb65f01a71cfb9e224e52830349944788; ?>
<?php unset($__attributesOriginalb65f01a71cfb9e224e52830349944788); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb65f01a71cfb9e224e52830349944788)): ?>
<?php $component = $__componentOriginalb65f01a71cfb9e224e52830349944788; ?>
<?php unset($__componentOriginalb65f01a71cfb9e224e52830349944788); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginalfa451f831f9754493ce4e887b6c48ef0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa451f831f9754493ce4e887b6c48ef0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input.form','data' => ['method' => 'post','action' => route('login'),'class' => 'space-y-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input.form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['method' => 'post','action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('login')),'class' => 'space-y-6']); ?>
            <div>
                <?php if (isset($component)) { $__componentOriginal19cc3573ede92eaeb5dbc7c019225f08 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal19cc3573ede92eaeb5dbc7c019225f08 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input.label','data' => ['for' => 'email']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'email']); ?><?php echo e(__('auth.your_email')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal19cc3573ede92eaeb5dbc7c019225f08)): ?>
<?php $attributes = $__attributesOriginal19cc3573ede92eaeb5dbc7c019225f08; ?>
<?php unset($__attributesOriginal19cc3573ede92eaeb5dbc7c019225f08); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal19cc3573ede92eaeb5dbc7c019225f08)): ?>
<?php $component = $__componentOriginal19cc3573ede92eaeb5dbc7c019225f08; ?>
<?php unset($__componentOriginal19cc3573ede92eaeb5dbc7c019225f08); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginald04c8f854c7e36bc6248f014a620dea9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald04c8f854c7e36bc6248f014a620dea9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input.input','data' => ['type' => 'email','name' => 'email','id' => 'email','class' => 'mt-1','placeholder' => __('auth.email_placeholder'),'required' => '','value' => old('email'),'autofocus' => true,'autocomplete' => 'username']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'email','name' => 'email','id' => 'email','class' => 'mt-1','placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('auth.email_placeholder')),'required' => '','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('email')),'autofocus' => true,'autocomplete' => 'username']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald04c8f854c7e36bc6248f014a620dea9)): ?>
<?php $attributes = $__attributesOriginald04c8f854c7e36bc6248f014a620dea9; ?>
<?php unset($__attributesOriginald04c8f854c7e36bc6248f014a620dea9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald04c8f854c7e36bc6248f014a620dea9)): ?>
<?php $component = $__componentOriginald04c8f854c7e36bc6248f014a620dea9; ?>
<?php unset($__componentOriginald04c8f854c7e36bc6248f014a620dea9); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginale317fb6d3b010a9957c1c23e1b63b8e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale317fb6d3b010a9957c1c23e1b63b8e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input.input-error','data' => ['messages' => $errors->get('email'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input.input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('email')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale317fb6d3b010a9957c1c23e1b63b8e9)): ?>
<?php $attributes = $__attributesOriginale317fb6d3b010a9957c1c23e1b63b8e9; ?>
<?php unset($__attributesOriginale317fb6d3b010a9957c1c23e1b63b8e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale317fb6d3b010a9957c1c23e1b63b8e9)): ?>
<?php $component = $__componentOriginale317fb6d3b010a9957c1c23e1b63b8e9; ?>
<?php unset($__componentOriginale317fb6d3b010a9957c1c23e1b63b8e9); ?>
<?php endif; ?>
            </div>

            <div>
                <?php if (isset($component)) { $__componentOriginal19cc3573ede92eaeb5dbc7c019225f08 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal19cc3573ede92eaeb5dbc7c019225f08 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input.label','data' => ['for' => 'password']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'password']); ?><?php echo e(__('auth.password')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal19cc3573ede92eaeb5dbc7c019225f08)): ?>
<?php $attributes = $__attributesOriginal19cc3573ede92eaeb5dbc7c019225f08; ?>
<?php unset($__attributesOriginal19cc3573ede92eaeb5dbc7c019225f08); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal19cc3573ede92eaeb5dbc7c019225f08)): ?>
<?php $component = $__componentOriginal19cc3573ede92eaeb5dbc7c019225f08; ?>
<?php unset($__componentOriginal19cc3573ede92eaeb5dbc7c019225f08); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginald04c8f854c7e36bc6248f014a620dea9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald04c8f854c7e36bc6248f014a620dea9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input.input','data' => ['type' => 'password','name' => 'password','id' => 'password','placeholder' => __('auth.password_placeholder'),'class' => 'mt-1','required' => '','autocomplete' => 'current-password']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'password','name' => 'password','id' => 'password','placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('auth.password_placeholder')),'class' => 'mt-1','required' => '','autocomplete' => 'current-password']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald04c8f854c7e36bc6248f014a620dea9)): ?>
<?php $attributes = $__attributesOriginald04c8f854c7e36bc6248f014a620dea9; ?>
<?php unset($__attributesOriginald04c8f854c7e36bc6248f014a620dea9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald04c8f854c7e36bc6248f014a620dea9)): ?>
<?php $component = $__componentOriginald04c8f854c7e36bc6248f014a620dea9; ?>
<?php unset($__componentOriginald04c8f854c7e36bc6248f014a620dea9); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginale317fb6d3b010a9957c1c23e1b63b8e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale317fb6d3b010a9957c1c23e1b63b8e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input.input-error','data' => ['messages' => $errors->get('password'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input.input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('password')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale317fb6d3b010a9957c1c23e1b63b8e9)): ?>
<?php $attributes = $__attributesOriginale317fb6d3b010a9957c1c23e1b63b8e9; ?>
<?php unset($__attributesOriginale317fb6d3b010a9957c1c23e1b63b8e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale317fb6d3b010a9957c1c23e1b63b8e9)): ?>
<?php $component = $__componentOriginale317fb6d3b010a9957c1c23e1b63b8e9; ?>
<?php unset($__componentOriginale317fb6d3b010a9957c1c23e1b63b8e9); ?>
<?php endif; ?>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <?php if (isset($component)) { $__componentOriginal66700085a0699ec9232be8d3eb1f9a69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal66700085a0699ec9232be8d3eb1f9a69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input.checkbox','data' => ['id' => 'remember','name' => 'remember']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input.checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'remember','name' => 'remember']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal66700085a0699ec9232be8d3eb1f9a69)): ?>
<?php $attributes = $__attributesOriginal66700085a0699ec9232be8d3eb1f9a69; ?>
<?php unset($__attributesOriginal66700085a0699ec9232be8d3eb1f9a69); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal66700085a0699ec9232be8d3eb1f9a69)): ?>
<?php $component = $__componentOriginal66700085a0699ec9232be8d3eb1f9a69; ?>
<?php unset($__componentOriginal66700085a0699ec9232be8d3eb1f9a69); ?>
<?php endif; ?>
                    <div class="ml-2">
                        <?php if (isset($component)) { $__componentOriginal19cc3573ede92eaeb5dbc7c019225f08 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal19cc3573ede92eaeb5dbc7c019225f08 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input.label','data' => ['for' => 'remember']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'remember']); ?><?php echo e(__('auth.remember_me')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal19cc3573ede92eaeb5dbc7c019225f08)): ?>
<?php $attributes = $__attributesOriginal19cc3573ede92eaeb5dbc7c019225f08; ?>
<?php unset($__attributesOriginal19cc3573ede92eaeb5dbc7c019225f08); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal19cc3573ede92eaeb5dbc7c019225f08)): ?>
<?php $component = $__componentOriginal19cc3573ede92eaeb5dbc7c019225f08; ?>
<?php unset($__componentOriginal19cc3573ede92eaeb5dbc7c019225f08); ?>
<?php endif; ?>
                    </div>
                </div>
                <?php if (isset($component)) { $__componentOriginal606bedd6108050b8303bc7c381e2387c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal606bedd6108050b8303bc7c381e2387c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.link','data' => ['href' => route('password.request')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('password.request'))]); ?><?php echo e(__('auth.forgot_password')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal606bedd6108050b8303bc7c381e2387c)): ?>
<?php $attributes = $__attributesOriginal606bedd6108050b8303bc7c381e2387c; ?>
<?php unset($__attributesOriginal606bedd6108050b8303bc7c381e2387c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal606bedd6108050b8303bc7c381e2387c)): ?>
<?php $component = $__componentOriginal606bedd6108050b8303bc7c381e2387c; ?>
<?php unset($__componentOriginal606bedd6108050b8303bc7c381e2387c); ?>
<?php endif; ?>
            </div>

            <?php if (isset($component)) { $__componentOriginal238d5211cc9d80261ec96f21f6b79bb3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal238d5211cc9d80261ec96f21f6b79bb3 = $attributes; } ?>
<?php $component = App\View\Components\Ui\Button::resolve(['type' => 'submit','variant' => 'primary'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Ui\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-full mt-4']); ?><?php echo e(__('auth.log_in')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal238d5211cc9d80261ec96f21f6b79bb3)): ?>
<?php $attributes = $__attributesOriginal238d5211cc9d80261ec96f21f6b79bb3; ?>
<?php unset($__attributesOriginal238d5211cc9d80261ec96f21f6b79bb3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal238d5211cc9d80261ec96f21f6b79bb3)): ?>
<?php $component = $__componentOriginal238d5211cc9d80261ec96f21f6b79bb3; ?>
<?php unset($__componentOriginal238d5211cc9d80261ec96f21f6b79bb3); ?>
<?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa451f831f9754493ce4e887b6c48ef0)): ?>
<?php $attributes = $__attributesOriginalfa451f831f9754493ce4e887b6c48ef0; ?>
<?php unset($__attributesOriginalfa451f831f9754493ce4e887b6c48ef0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa451f831f9754493ce4e887b6c48ef0)): ?>
<?php $component = $__componentOriginalfa451f831f9754493ce4e887b6c48ef0; ?>
<?php unset($__componentOriginalfa451f831f9754493ce4e887b6c48ef0); ?>
<?php endif; ?>
    </div>

     <?php $__env->slot('footer', null, []); ?> 
        <?php echo e(__("auth.no_account")); ?> <?php if (isset($component)) { $__componentOriginal606bedd6108050b8303bc7c381e2387c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal606bedd6108050b8303bc7c381e2387c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.link','data' => ['href' => route('register')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('register'))]); ?><?php echo e(__('auth.sign_up')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal606bedd6108050b8303bc7c381e2387c)): ?>
<?php $attributes = $__attributesOriginal606bedd6108050b8303bc7c381e2387c; ?>
<?php unset($__attributesOriginal606bedd6108050b8303bc7c381e2387c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal606bedd6108050b8303bc7c381e2387c)): ?>
<?php $component = $__componentOriginal606bedd6108050b8303bc7c381e2387c; ?>
<?php unset($__componentOriginal606bedd6108050b8303bc7c381e2387c); ?>
<?php endif; ?>
     <?php $__env->endSlot(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal63025df94105f25d292e3d74a8fd1c9c)): ?>
<?php $attributes = $__attributesOriginal63025df94105f25d292e3d74a8fd1c9c; ?>
<?php unset($__attributesOriginal63025df94105f25d292e3d74a8fd1c9c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal63025df94105f25d292e3d74a8fd1c9c)): ?>
<?php $component = $__componentOriginal63025df94105f25d292e3d74a8fd1c9c; ?>
<?php unset($__componentOriginal63025df94105f25d292e3d74a8fd1c9c); ?>
<?php endif; ?>
<?php /**PATH /www/wwwroot/todoapp.prus.dev/resources/views/auth/login.blade.php ENDPATH**/ ?>