<ul class="tabsB cf">
        <li><a href="#tab-1">Subjects</a></li>
        <li><a href="#tab-2">Create Subject</a></li>
</ul>
<div class="content_panes">
    <? if(isset($subjects))
        echo $subjects;?>
    <? if(isset($create_subject))
        echo $create_subject;?>
</div>