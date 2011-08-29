<div class="projectread">
    <div class="top">
        <div class="topleft">
            <h1><?=$title; ?></h1>
        </div>
        <div class="topright">
            <p class="linkback"><?=$link_back2 ?>&nbsp;<?=$link_back; ?></p>
        </div>
    </div>
    <div class="clear"></div>
    <div class="data">
        <div class="row">
            <label class="lblleft">Title</label>
            <label class="lblright"><?=$project->title; ?></label>
        </div>
        <div class="row">
            <label class="lblleft">Description</label>
            <label class="lblright"><?=$project->description; ?></label>
        </div>
        <div class="row">
            <label class="lblleft">Link to Work</label>
            <label class="lblright"><?=$project->urlwork; ?></label>
        </div>
        <div class="row">
            <label class="lblleft">Image Left</label>
            <label class="lblright"><?=$imageleft; ?><?=$project->altleft; ?></label>
        </div>
        <div class="row">
            <label class="lblleft">Image Right Top</label>
            <label class="lblright"><?=$imagerighttop; ?><?=$project->altrighttop; ?></label>
        </div>
        <div class="row">
            <label class="lblleft">Image Right Bottom</label>
            <label class="lblright"><?=$imagerightbottom; ?><?=$project->altrightbottom; ?></label>
        </div>
    </div>
</div>