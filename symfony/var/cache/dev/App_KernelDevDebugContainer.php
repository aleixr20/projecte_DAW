<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerGyjVjxO\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerGyjVjxO/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerGyjVjxO.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerGyjVjxO\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerGyjVjxO\App_KernelDevDebugContainer([
    'container.build_hash' => 'GyjVjxO',
    'container.build_id' => '5fe55a0f',
    'container.build_time' => 1588856844,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerGyjVjxO');
