 <div class="projects">
     <div class="top">
         <div class="topleft">
             <h1><?=$title; ?></h1>
         </div>
         <div class="topright">
             <p class="linkback"><?=anchor('project/add/','Add New Project',array('class'=>'add')); ?></p>
         </div>
     </div>
     <div class="clear"></div>
     <div class="paging">
         <?=$pagination; ?>
     </div>
     <div class="clear"></div>
     <div class="data">
         <?=$table; ?>
     </div>
     <?=$noprojects; ?>
 </div>
        