<div id="disciplinary-block">
    <table  cellpadding="0" cellspacing="0" border="0" class="table-records table_a smpl_tbl">
        <thead>
            <tr>
                <th><div class="th_wrapp">Date</div></th>
                <th><div class="th_wrapp">Record</div></th>
                <th><div class="th_wrapp">Notes</div></th>
                <th><div class="th_wrapp">Action (office Notes)</div></th>
                <? if($role == 'sadmin' OR $role == 'admin'):?>
                    <th><div class="th_wrapp">Actions</div></th>
                <? endif?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($records as $record): ?>
            <tr>
                <td><?php echo date('d-m-y', $record->date) ?></td>
                <td><?php echo $record->record ?></td>
                <td><?php echo $record->notes ?></td>
                <td><?php echo $record->action ?></td>
                <? if($role == 'sadmin' OR $role == 'admin'):?>
                    <td style="text-align: center;">
                        <div id="actions">
                            <a href="<?php echo URL::base()?><?=$role?>/disciplinarystudents/edit/<?php echo $student->student_id ?>&<?php echo $year ?>&<?php echo $record->id ?>"
                                   class="sepV_a" title="Edit">
                                <button class="action-button" value="">
                                    <img src="<?=URL::base()?>laguadmin/images/icons/pencil_gray.png">
                                </button>
                            </a>
                            
                            <button name="Delete" value="<?=$student->student_id.'&'.$year.'&'.$record->id?>" data-toggle="modal" href="#deleteDisciplinaryModal" 
                                class="action-button disciplinary_delete_button">
                                <a href="" title="Delete">
                                    <img src="<?=URL::base()?>laguadmin/images/icons/trashcan_gray.png">
                                </a>
                            </button>
                        </div>
                    </td>
                <? endif?>
            </tr>
            <?php endforeach; ?>
        <tbody>
    </table>
</div>
<div style="display: none;" class="modal hide" id="deleteDisciplinaryModal">
    <div class="tac">
        <form action="<?=URL::base()?><?=$role?>/disciplinarystudents/delete" method="post">
            <input id="delete_disciplinary" type="hidden" name="delete_disciplinary" value="" />
            <p class="sepH_b">Are you sure you want to delete the disciplinary record?</p>
            <button type="submit" id="clear_yes" class="btn btn_d sepV_a">Yes</button>
            <button id="clear_no" class="btn btn_a" data-dismiss="modal">No</button >
        </form>
    </div>
</div>