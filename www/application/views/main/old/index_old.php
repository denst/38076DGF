<p>Hello <strong><?php echo $user_info->name ?></strong></p>
<?php if(Helper_User::getUserRole($user) == 'student'): ?>
    <?php if(!is_null($user->students->find()->class_id)): ?>
        <p>Current class: <a href="<?php echo URL::base() ?>classes/view/<?php echo $user->students->find()->class_id ?>"><?php echo $user->students->find()->class->level->name . $user->students->find()->class->name ?></a></p>
    <?php endif;?>
    <a href="<?php echo URL::base() ?>academic-records/list/<?php echo $user->id ?>">Academic Record</a> 
    <br>
    <a href="<?php echo URL::base() ?>achievement-records/list/<?php echo $user->id ?>">Achievement Record</a>
    <br>
    <a href="<?php echo URL::base() ?>disciplinary-records/list/<?php echo $user->id ?>">Disciplinary Record</a>
    <br>
    <a href="<?php echo URL::base() ?>financial-records/list/<?php echo $user->id ?>">Financial Record</a>
<?php endif; ?>
<p>You are <strong><?php echo Helper_User::getUserRole($user) ?></p>
<?php if(Helper_User::getUserRole($user) == 'teacher'): ?>
    <a href="<?php echo URL::base() ?>achievement-teacher-records/list/<?php echo $user->teachers->find()->teacher_id ?>">Achievement Record</a>
    <br>
    <a href="<?php echo URL::base() ?>disciplinary-teacher-records/list/<?php echo $user->teachers->find()->teacher_id ?>">Disciplinary Record</a>         
    <br>
<?php endif; ?>
<?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin'  || Helper_User::getUserRole($user) == 'teacher'): ?>
    <p><a href="<?php echo URL::base() ?>students/list">Students</a></p>
<?php endif; ?>
<?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin'): ?>
    <p><a href="<?php echo URL::base() ?>teachers/list">Teachers</a></p>
<?php endif; ?>
<?php if(Helper_User::getUserRole($user) == 'sadmin'): ?>
    <p><a href="<?php echo URL::base() ?>admins/list">Admins</a></p>
<?php endif;?>
<?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin'): ?>
    <p><a href="<?php echo URL::base() ?>levels/list">Grade Levels</a></p>
    <p><a href="<?php echo URL::base() ?>subjects/list">Subjects</a></p>
<?php endif; ?>
<?php if(Helper_User::getUserRole($user) == 'sadmin'): ?>
    <p><a href="<?php echo URL::base() ?>academic-period">Academic Period</a></p>
<?php endif; ?>