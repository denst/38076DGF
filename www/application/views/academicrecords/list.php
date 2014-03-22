<div id="tab-1" class="formEl_a">
    <fieldset>
        <legend>Academic Records</legend>
        <h3><a href="<?=URL::base().$role?>/students/view/<?=$student->student_id?>"><?php echo $student->user->username ?> (<?php echo $student->name ?> <?php echo $student->fathername ?> <?php echo $student->grfathername ?>)</a></h3>
        <br>
        <? if($role != 'student'):?>
            <?php if(!empty($subjects) && count($subjects) > 0): ?>
                <? if(isset($table_class)){
                    echo $table_class;
                }?>
            <?php endif;?>
        <?php endif;?>
        <div class="sepH_b">
            <form name="form_year" id="form_year" action="<?php echo URL::base() ?><?=$role?>/academicrecords/list/<?php echo $student->student_id ?>">
                <select name="year" id="year">
                    <?php for($i = $student->start_year; $i <= $student->end_year; $i++): ?>
                        <option <?php echo $i == $year ? 'selected' : '' ?> value="<?php echo $i ?>"><?php echo ORM::factory('academicyear', $i)->name ?>/<?php echo ORM::factory('academicyear', $i + 1)->name ?></option>
                    <?php endfor; ?>
                </select>
            </form>
        </div>

        <div class="sepH_b">
            <?php if(count($subjects_records) > 0): ?>
                <? if(isset($table)):?>
                    <? echo $table;?>
                    <div style="display: none;" class="modal hide" id="deleteRecordModal">
                        <div class="tac">
                            <form action="<?=URL::base()?><?=$role?>/academicrecords/delete" method="post">
                                <input id="delete_academic" type="hidden" name="delete_academic" value="" />
                                <p class="sepH_b">Are you sure you want to delete the academic record?</p>
                                <button type="submit" id="clear_yes" class="btn btn_d sepV_a">Yes</button>
                                <button id="clear_no" class="btn btn_a" data-dismiss="modal">No</button >
                            </form>
                        </div>
                    </div>
                    <? if($role != 'student'):?>
                    <div id="pdf-block">
                        <a href="<?=URL::base().$role?>/academicrecords/pdfdownload/<?=$student->student_id?>" class="btn btn_dL sepH_b">Download PDF Report</a>
                        <a href="<?=URL::base().$role?>/academicrecords/pdfview/<?=$student->student_id?>" class="btn btn_dL sepH_b">View PDF Report</a>
                    </div>
                    <? endif?>
                    <div id="pdf-block">
                        <a href="<?=URL::base().$role?>/academicrecords/transcriptdownload/<?=$student->student_id?>" class="btn btn_dL sepH_b">Download Transcript</a>
                        <a href="<?=URL::base().$role?>/academicrecords/transcriptview/<?=$student->student_id?>" class="btn btn_dL sepH_b">View Transcript</a>
                    </div>
                <? endif?>
            <?php else: ?>
                <p>No records for selected year</p>
            <?php endif; ?>
        </div>
    </fieldset>
</div>