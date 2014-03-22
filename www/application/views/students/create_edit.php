<div id="tab-3">
    <div class="sepH_c">
        <div id="user-block">
            <div style="display: <?=(isset($dropout_student)? 'block;': 'none;')?>" class="dropout_box msg_error">
                Maybe this student dropped learning, are you sure you want to create this student
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button id="dropout_student">Yes</button>
                <button id="dropout_student_close">No</button>
                <img src="<?=  URL::base()?>laguadmin/images/blank.gif" class="msg_close" alt="">
            </div>
            <?php if(!empty($success)): ?>
                <div class="success">
                    <p><?php echo $success ?></p>
                </div>
            <?php endif; ?>
            <? if(isset($edit)):?>
                <h1 class="sepH_c">Edit Student Profile</h1>
            <? else:?>
                <h1 class="sepH_c">Create Student Profile</h1>
            <? endif?>
            <div class="cf formEl sepH_b">
                <form id="imageform" method="post" enctype="multipart/form-data" action='<?=URL::base()?>ajax/ajaximage'>
                    <div class="dp33 tac">
                        <img id="img-polaroid" alt="" src="<?=(isset($user_data) AND Valid::not_empty($user_data['image']))?
                            URL::base().'files/users/'.$user_data['student_id'].'/110x110/'.$user_data['image']: 
                            '/laguadmin/images/user_noPhoto100.gif'?>" />
                        <div id="block-loader">
                        </div>
                        <input type="file" name="photoimg" id="photoimg" />
                    </div>
                </form>

                <? if(isset($register)):?>
                <form class="formEl_a form students-form" name="register_student" 
                      action="<?php echo URL::base() ?>session/registerstudent" method="POST" >
                <? elseif(isset($edit)):?>
                <form class="formEl_a form students-form" name="edit_student" 
                      action="<?php echo URL::base() ?><?=$role?>/students/edit/<?php echo $user->id ?>" method="POST" >
                <? else:?>
                <form id="lga_form_a_validation" class="formEl_a form students-form" name="create_student" 
                      action="<?php echo URL::base() ?><?=$role?>/students/create" method="POST" >
                <? endif;?>
                    <input type="hidden" id="image_path" name="image_path" value=""/>
                    <div class="dp60">
                        <? if(isset($user_data)):?>
                            <input type="hidden" name="student_id" value="<?=$user_data['student_id']?>">
                        <? endif;?>
                            
                        <fieldset id="main-info">
                            <legend>Main info</legend>
                            <? if(isset($edit)):?>
                            <div class="sepH_b">
                                <label class="lbl_b">Studenst ID (Login) - <?=$user->username?></label>
                            </div>
                            <? endif;?>
                            <div class="sepH_b" <?=empty($edit)? 'id="academic_year"': ''?>>
                                <label for="a_select" class="lbl_b">STUDENTS ADMISSION FORM FOR GRADES 1-12 ACADEMIC YEAR</label>
                                <select name="academic_year" id="a_select">
                                    <?php foreach($levels as $level): ?>
                                    <? if(isset($user_data)):?>
                                        <option value="<?php echo $level->id ?>" <?php echo $level->id == $user_data['academic_year'] ? 'selected' : '' ?>><?php echo $level->name ?></option>
                                    <? else:?>
                                        <option value="<?php echo $level->id ?>"><?php echo $level->name ?></option>
                                    <? endif?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>First Name/Father's Name/Grandfather's Name</legend>
                            <div class="sepH_b">
                                <label for="name" class="lbl_a">First Name<?(isset($edit))? '<b class="req"> *</b>': ''?>:</label>
                                <input type="text" name="name" id="name" class="inpt_a 
                                    <?=(! isset($user_data))? 'required': ''?>" value="<?=(isset($user_data))? $user_data['name']: ''?>">
                            </div>
                            <div class="sepH_b">
                                <label for="fathername" class="lbl_a">Father's Name<?(isset($edit))? '<b class="req"> *</b>': ''?>:</label>
                                <input type="text" name="fathername" id="fathername" class="inpt_a 
                                    <?=(! isset($user_data))? 'required': ''?>" value="<?=(isset($user_data))? $user_data['fathername']: ''?>"/>
                            </div>
                            <div class="sepH_b">
                                <label for="grfathername" class="lbl_a">Grandfather's Name<?(isset($edit))? '<b class="req"> *</b>': ''?>:</label>
                                <input type="text" name="grfathername" id="grfathername" class="inpt_a 
                                    <?=(! isset($user_data))? 'required': ''?>" value="<?=(isset($user_data))? $user_data['grfathername']: ''?>" />
                            </div>
                        </fieldset>
                            
                        <fieldset>
                            <? if(isset($errors))
                                $email_error = key_exists('email', $errors);
                            ?>
                            <legend>Email</legend>
                            <div class="sepH_b <?=($email_error)? 'error': ''?>"">
                                <label for="name" class="lbl_a">Email<?(isset($edit))? '<b class="req"> *</b>': ''?>:</label>
                                <input type="text" name="email" id="email" class="inpt_a 
                                    <?=(! isset($user_data))? 'required': ''?>" value="<?=(isset($user_data))? $user_data['email']: ''?>">
                            </div>
                        </fieldset>
                        
                        <? if(! isset($register)):?>
                            <fieldset>
                                <legend>Password</legend>
                                <? if(isset($errors))
                                    $password_error = key_exists('password', $errors);
                                ?>
                                <div class="sepH_b <?=($password_error)? 'error': ''?>"">
                                    <label for="password" class="lbl_a">Password<?(isset($edit))? '<b class="req"> *</b>': ''?>:</label>
                                    <input type="password" name="password" id="name" class="inpt_a 
                                        <?=(! isset($user_data))? 'required': ''?>" value="">                                    
                                </div>
                                <? if(isset($errors))
                                    $confirm_password_error = key_exists('password_confirm', $errors);
                                ?>
                                <div class="sepH_b <?=($confirm_password_error)? 'error': ''?>"">
                                    <label for="password_confirm" class="lbl_a">Confirm Password<?(isset($edit))? '<b class="req"> *</b>': ''?>:</label>
                                    <input type="password" name="password_confirm" id="name" class="inpt_a 
                                        <?=(!isset($user_data))? 'required': ''?>" value="">
                                </div>
                            </fieldset>
                        <? endif;?>

                        <fieldset>
                            <legend>Birthday/Sex</legend>
                            <div class="sepH_c cf">
                                <label for="datepick-1" class="lbl_a">Date of birth (E.C):</label>
                                <input type="text" name="dob[ec]" id="datepick-1" class="inpt_b datepicker
                                       <?=(! isset($user_data))? 'required': ''?>" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
                            </div>
                            <div class="sepH_c cf">
                                <label for="datepick-2" class="lbl_a">Date of birth (G.C):</label>
                                <input type="text" name="dob[gc]" id="datepick-2" class="inpt_b datepicker
                                       <?=(! isset($user_data))? 'required': ''?>" value="<?=(isset($user_data))? $user_data['dob']['gc']: ''?>"/>
                            </div>
                            <div class="sepH_b">
                                <label for="sex" class="lbl_a">Sex:</label>
                                <select name="sex" id="a_select">
                                    <option value="0" <?=(isset($user_data) AND $user_data['sex'] == '0')? 'selected': ''?>>Male</option>
                                    <option value="1" <?=(isset($user_data) AND $user_data['sex'] == '1')? 'selected': ''?>>Female</option>
                                </select>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Home Address</legend>
                            <div class="sepH_b">
                                <label for="address_kk" class="lbl_a">Kifle Ketema:</label>
                                <input type="text" name="address[kk]" id="address_kk" class="inpt_a" value="<?=(isset($user_data))? $user_data['address']['kk']: ''?>"/>
                            </div>
                            <div class="sepH_b">
                                <label for="address_k" class="lbl_a">Kebele:</label>
                                <input type="text" name="address[k]" id="address_k" class="inpt_a" value="<?=(isset($user_data))? $user_data['address']['k']: ''?>"/>
                            </div>
                            <div class="sepH_b">
                                <label for="address_h" class="lbl_a">House No.:</label>
                                <input type="text" name="address[h]" id="address_h" class="inpt_a" value="<?=(isset($user_data))? $user_data['address']['h']: ''?>"/>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Father Information</legend>
                            <div class="sepH_b">
                                <label for="father_name" class="lbl_a">Name:</label>
                                <input type="text" name="father[name]" id="father_name" class="inpt_a" value="<?=(isset($user_data))? $user_data['father']['name']: ''?>"/>
                            </div>
                            <div class="sepH_b">
                                <label for="father_occ" class="lbl_a">Occupation:</label>
                                <input type="text" name="father[occ]" id="father_occ" class="inpt_a" value="<?=(isset($user_data))? $user_data['father']['occ']: ''?>"/>
                            </div>
                            <div class="sepH_b">
                                <label for="father_pw" class="lbl_a">Place of work:</label>
                                <input type="text" name="father[pw]" id="father_pw" class="inpt_a" value="<?=(isset($user_data))? $user_data['father']['pw']: ''?>"/>
                            </div>
                            <fieldset>
                                <legend>Telephone</legend>
                                <div class="sepH_b">
                                    <label for="father_telephone_of" class="lbl_a">Office:</label>
                                    <input type="text" name="father[telephone][of]" id="father_telephone_of" class="inpt_a" value="<?=(isset($user_data))? $user_data['father']['telephone']['of']: ''?>"/>
                                </div>
                                <div class="sepH_b">
                                    <label for="father_telephone_m" class="lbl_a">Telephone:</label>
                                    <input type="text" name="father[telephone][m]" id="father_telephone_m" class="inpt_a" value="<?=(isset($user_data))? $user_data['father']['telephone']['m']: ''?>"/>
                                </div>
                                <div class="sepH_b">
                                    <label for="father_telephone_r" class="lbl_a">Residence:</label>
                                    <input type="text" name="father[telephone][r]" id="father_telephone_r" class="inpt_a" value="<?=(isset($user_data))? $user_data['father']['telephone']['r']: ''?>"/>
                                </div>
                            </fieldset>
                        </fieldset>

                        <fieldset>
                            <legend>Mother Information</legend>
                            <div class="sepH_b">
                                <label for="mother_name" class="lbl_a">Name:</label>
                                <input type="text" name="mother[name]" id="mother_name" class="inpt_a" value="<?=(isset($user_data))? $user_data['mother']['name']: ''?>"/>
                            </div>
                            <div class="sepH_b">
                                <label for="mother_occ" class="lbl_a">Occupation:</label>
                                <input type="text" name="mother[occ]" id="mother_occ" class="inpt_a" value="<?=(isset($user_data))? $user_data['mother']['occ']: ''?>"/>
                            </div>
                            <div class="sepH_b">
                                <label for="mother_pw" class="lbl_a">Place of work:</label>
                                <input type="text" name="mother[pw]" id="mother_pw" class="inpt_a" value="<?=(isset($user_data))? $user_data['mother']['pw']: ''?>"/>
                            </div>
                            <fieldset>
                                <legend>Telephone</legend>
                                <div class="sepH_b">
                                    <label for="mother_telephone_of" class="lbl_a">Office:</label>
                                    <input type="text" name="mother[telephone][of]" id="mother_telephone_of" class="inpt_a" value="<?=(isset($user_data))? $user_data['mother']['telephone']['of']: ''?>"/>
                                </div>
                                <div class="sepH_b">
                                    <label for="mother_telephone_m" class="lbl_a">Telephone:</label>
                                    <input type="text" name="mother[telephone][m]" id="mother_telephone_m" class="inpt_a" value="<?=(isset($user_data))? $user_data['mother']['telephone']['m']: ''?>"/>
                                </div>
                                <div class="sepH_b">
                                    <label for="mother_telephone_r" class="lbl_a">Residence:</label>
                                    <input type="text" name="mother[telephone][r]" id="mother_telephone_r" class="inpt_a" value="<?=(isset($user_data))? $user_data['mother']['telephone']['r']: ''?>"/>
                                </div>
                            </fieldset>
                        </fieldset>
                        
                        <fieldset>
                            <legend>Guardian Information</legend>
                            <div class="sepH_b">
                                <label for="guardian_name" class="lbl_a">Name:</label>
                                <input type="text" name="guardian[name]" id="guardian_name" class="inpt_a" value="<?=(isset($user_data))? $user_data['guardian']['name']: ''?>"/>
                            </div>
                            <div class="sepH_b">
                                <label for="guardian_rel" class="lbl_a">Relation to the student:</label>
                                <input type="text" name="guardian[rel]" id="guardian_rel" class="inpt_a" value="<?=(isset($user_data))? $user_data['guardian']['rel']: ''?>"/>
                            </div>
                            <div class="sepH_b">
                                <label for="guardian_pw" class="lbl_a">Place of work:</label>
                                <input type="text" name="guardian[pw]" id="guardian_pw" class="inpt_a" value="<?=(isset($user_data))? $user_data['guardian']['pw']: ''?>"/>
                            </div>
                            <fieldset>
                                <legend>Telephone</legend>
                                <div class="sepH_b">
                                    <label for="guardian_telephone_of" class="lbl_a">Office:</label>
                                    <input type="text" name="guardian[telephone][of]" id="guardian_telephone_of" class="inpt_a" value="<?=(isset($user_data))? $user_data['guardian']['telephone']['of']: ''?>"/>
                                </div>
                                <div class="sepH_b">
                                    <label for="guardian_telephone_m" class="lbl_a">Telephone:</label>
                                    <input type="text" name="guardian[telephone][m]" id="guardian_telephone_m" class="inpt_a" value="<?=(isset($user_data))? $user_data['guardian']['telephone']['m']: ''?>"/>
                                </div>
                            </fieldset>
                        </fieldset>

                        <fieldset id="contacts-block">
                            <legend>Contacts telephones in case of emergency (give detailed information)</legend>
                            <div class="tels">
                                <? if(isset($user_data)):?>
                                <?php foreach ($user_data['tels_em'] as $key => $tel): ?>
                                    <div class="group-field-block tel">
                                        <div class="sepH_b">
                                            <label for="tels_em_<?php echo $key ?>_name">Name:</label>
                                            <input type="text" name="tels_em[<?php echo $key ?>][name]"
                                               class="tels_em_name inpt_b" id="tels_em_<?php echo $key ?>_name" 
                                               value="<?php echo $tel['name'] ?>">
                                        </div>
                                        <div class="sepH_b">
                                            <label for="tels_em_<?php echo $key ?>_tel">Tel. No.</label>
                                            <input type="text" name="tels_em[<?php echo $key ?>][tel]" 
                                                   class="tels_em_tel inpt_b" id="tels_em_<?php echo $key ?>_tel" 
                                                   value="<?php echo $tel['tel'] ?>">
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <? else:?>
                                    <div class="group-field-block tel">
                                        <div class="sepH_b">
                                            <label for="tels_em_0_name">Name:</label>
                                            <input type="text" name="tels_em[0][name]"
                                               class="tels_em_name inpt_b" id="tels_em_0_name" 
                                               value="">
                                        </div>
                                        <div class="sepH_b">
                                            <label for="tels_em_0_tel">Tel. No.</label>
                                            <input type="text" name="tels_em[0][tel]" 
                                                   class="tels_em_tel inpt_b" id="tels_em_0_tel" 
                                                   value="">
                                        </div>
                                    </div>
                                <? endif;?>
                            </div>
                            <div>
                                <img id="more-tel" src="<?=URL::base()?>/laguadmin/images/icons/add.png" alt="">
                            </div>
                        </fieldset>

                        <fieldset id="languages">
                            <legend>Languages spoken at home:</legend>
                            <div class="sepH_b">
                                <label for="languages_0" class="lbl_a">1:</label>
                                <input type="text" name="languages[0]" id="languages_0" class="inpt_a" value="<?=(isset($user_data))? $user_data['languages']['0']: ''?>"/>
                            </div>
                            <div class="sepH_b">
                                <label for="languages_1" class="lbl_a">2:</label>
                                <input type="text" name="languages[1]" id="languages_1" class="inpt_a" value="<?=(isset($user_data))? $user_data['languages']['1']: ''?>"/>
                            </div>
                            <div class="sepH_b">
                                <label for="languages_2" class="lbl_a">3:</label>
                                <input type="text" name="languages[2]" id="languages_2" class="inpt_a" value="<?=(isset($user_data))? $user_data['languages']['2']: ''?>"/>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Any health conditions that the school should know about:</legend>
                            <div class="sepH_b">
                                <label for="health" class="lbl_a">Please specify:</label>
                                <div id="health_conditions">
                                    <?if(isset($user_data)):?>
                                    <?php foreach ($user_data['health'] as $key => $value): ?>
                                    <div class="condition">
                                        <input type="text" id="health-<?=$key?>" name="health[]" id="health" class="inpt_a input_cond" value="<?=$value?>"/>
                                        <a href="#" class="remove-condition" id="<?=$key?>">
                                            <img class="delete-button" src="http://dandiigo.loc/laguadmin/images/icons/trashcan_gray.png">
                                        </a>
                                    </div>
                                    <? endforeach;?>
                                    <? else:?>
                                        <div class="condition">
                                            <input type="text" id="health[0]" name="health[]" id="health" class="inpt_a input_cond" value=""/>
                                            <a href="#" class="remove-condition" id="0">
                                            <img class="delete-button" src="http://dandiigo.loc/laguadmin/images/icons/trashcan_gray.png">
                                        </a>
                                        </div>
                                    <? endif?>
                                </div>
                            </div>
                            <div>
                                <img id="more-conditions" src="<?=URL::base()?>/laguadmin/images/icons/add.png" alt="">
                            </div>
                        </fieldset>

                        <fieldset id="brothers">
                            <legend>Does the applicant have any siblings (brothers or sisters) learning in Dandii Boru School? If yes give particulars:</legend>
                            <div class="siblings">
                                <? if(isset($user_data)):?>
                                <?php foreach($user_data['siblings'] as $key => $sib): ?>
                                    <div class="group-field-block sib">
                                        <div class="sepH_b">
                                            <label for="siblings_<?php echo $key ?>_name" class="lbl_a">Name:</label>
                                            <input type="text" name="siblings[<?php echo $key ?>][name]" 
                                                   class="siblings_name inpt_b" id="siblings_<?php echo $key ?>_name"
                                                   value="<?php echo $sib['name'] ?>">
                                        </div>
                                        <div class="sepH_b">
                                            <label for="siblings_<?php echo $key ?>_grade" class="lbl_a">Grade & section:</label>
                                            <input type="text" name="siblings[<?php echo $key ?>][grade]" 
                                                   class="siblings_grade inpt_b" id="siblings_<?php echo $key ?>_grade" 
                                                   value="<?php echo $sib['grade'] ?>">
                                        </div>
                                        <div class="sepH_b">
                                            <label for="siblings_<?php echo $key ?>_rel" class="lbl_a">Relation:</label>
                                            <input type="text" name="siblings[<?php echo $key ?>][rel]"
                                                   class="siblings_rel inpt_b" id="siblings_<?php echo $key ?>_rel"
                                                   value="<?php echo $sib['rel'] ?>">
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <? else:?>
                                <div class="group-field-block sib">
                                    <div class="sepH_b">
                                            <label for="siblings_0_name" class="lbl_a">Name:</label>
                                            <input type="text" name="siblings[0][name]" 
                                                   class="siblings_name inpt_b" id="siblings_0_name"
                                                   value="">
                                        </div>
                                        <div class="sepH_b">
                                            <label for="siblings_0_grade" class="lbl_a">Grade & section:</label>
                                            <input type="text" name="siblings[0][grade]" 
                                                   class="siblings_grade inpt_b" id="siblings_0_grade" 
                                                   value="">
                                        </div>
                                        <div class="sepH_b">
                                            <label for="siblings_0_rel" class="lbl_a">Relation:</label>
                                            <input type="text" name="siblings[0][rel]"
                                                   class="siblings_rel inpt_b" id="siblings_0_rel"
                                                   value="">
                                        </div>
                                </div>
                                <? endif;?>
                            </div>
                            <div>
                                <a href="#" id="more-sib"><img src="<?php echo URL::base() ?>/laguadmin/images/icons/add.png"></a>
                            </div>
                        </fieldset>
                        
                        <? if(isset($edit)):?>
                        <button type="submit" id="submit_button" class="btn btn_dL sepH_b">Update student</button>
                        <? else:?>
                        <button type="submit" id="submit_button" class="btn btn_dL sepH_b">Create student</button>
                        <? endif;?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<a style="display: none" id="is_dropout" data-toggle="modal" href="#isDropoutStudentModal"><button id="drop_button">vdfvdv</button></a>
<div style="display: none;" class="modal hide" id="isDropoutStudentModal">
    <div class="tac">
        <p class="sepH_b">Are you sure you want to delete student?</p>
        <button type="submit" id="clear_yes" class="btn btn_d sepV_a">Yes</button>
        <button id="clear_no" class="btn btn_a" data-dismiss="modal" onclick="$('.form').submit(false);">No</button >
    </div>
</div>