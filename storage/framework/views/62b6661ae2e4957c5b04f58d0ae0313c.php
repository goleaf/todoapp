<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'description',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title',
    'description',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>





<div class="text-center">
    <?php if (isset($component)) { $__componentOriginalbe907cc0995d3a234bd36f3213a34e40 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbe907cc0995d3a234bd36f3213a34e40 = $attributes; } ?>
<?php $component = App\View\Components\Layout\Heading::resolve(['size' => 'xl'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout.heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layout\Heading::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e($title); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbe907cc0995d3a234bd36f3213a34e40)): ?>
<?php $attributes = $__attributesOriginalbe907cc0995d3a234bd36f3213a34e40; ?>
<?php unset($__attributesOriginalbe907cc0995d3a234bd36f3213a34e40); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbe907cc0995d3a234bd36f3213a34e40)): ?>
<?php $component = $__componentOriginalbe907cc0995d3a234bd36f3213a34e40; ?>
<?php unset($__componentOriginalbe907cc0995d3a234bd36f3213a34e40); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal8dda6acf3e2d07a37a887103e6b63f9f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8dda6acf3e2d07a37a887103e6b63f9f = $attributes; } ?>
<?php $component = App\View\Components\Layout\Subheading::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout.subheading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layout\Subheading::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e($description); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8dda6acf3e2d07a37a887103e6b63f9f)): ?>
<?php $attributes = $__attributesOriginal8dda6acf3e2d07a37a887103e6b63f9f; ?>
<?php unset($__attributesOriginal8dda6acf3e2d07a37a887103e6b63f9f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8dda6acf3e2d07a37a887103e6b63f9f)): ?>
<?php $component = $__componentOriginal8dda6acf3e2d07a37a887103e6b63f9f; ?>
<?php unset($__componentOriginal8dda6acf3e2d07a37a887103e6b63f9f); ?>
<?php endif; ?>
</div>
<?php /**PATH /www/wwwroot/todoapp.prus.dev/resources/views/components/auth/auth-header.blade.php ENDPATH**/ ?>