<?php if(count($subjects) > 0): ?>
<table class="table table-condensed">
        <thead>
            <tr>
                <th>Name</th>
                <th>Parent Subject</th>
                <th style="width: 20%">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($subjects as $subject): ?>
            <tr>
                <th><?php echo $subject->name ?></th>
                <th>-</th>
                <th>
                    <a href="<?php echo URL::base() ?>subjects/edit/<?php echo $subject->id ?>">Edit</a>
                </th>
            </tr>
            <?php $subjects_childrs = ORM::factory('subject')->where('pid', '=', $subject->id)->find_all() ?>
            <?php if(count($subjects_childrs) > 0): ?>
                <?php foreach($subjects_childrs as $subject_childr): ?>
                    <tr>
                        <th><?php echo $subject_childr->name ?></th>
                        <th><?php echo $subject->name ?></th>
                        <th>
                            <a href="<?php echo URL::base() ?>subjects/edit/<?php echo $subject_childr->id ?>">Edit</a>
                        </th>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
</table>
<?php else: ?>
    <p>The subjects are not found</p>
<?php endif; ?>
<a href="<?php echo URL::base() ?>subjects/new">Create subject</a>