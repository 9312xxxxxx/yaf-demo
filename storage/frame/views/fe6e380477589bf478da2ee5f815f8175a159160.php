hello , <?php echo e($name); ?> !
<ul>
<?php foreach($list as $item): ?>
    <li>姓名：<?php echo e($item['name']); ?> -- 年龄：<?php echo e($item['age']); ?></li>
<?php endforeach; ?>
</ul>
