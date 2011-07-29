
        <div class="content">
            <h1><?php echo $title; ?></h1>
            <div class="paging"><?php echo $pagination; ?></div>
            <div class="data"><?php echo $table; ?></div>
            <?php echo $noprojects; ?>
            <br />
            <?php echo anchor('project1/add/','Add New Project',array('class'=>'add')); ?>
        </div>
        