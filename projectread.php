
        <div class="content">
            <h1><?php echo $title; ?></h1>
            <div class="data">
                <table>
                    <tr>
                        <td valign="top">Title</td>
                        <td><?php echo $project->title; ?></td>
                    </tr>
                    <tr>
                        <td valign="top">Description</td>
                        <td><?php echo $project->description; ?></td>
                    </tr>
                    <tr>
                        <td valign="top">Link to Work</td>
                        <td><?php echo $project->urlwork; ?></td>
                    </tr>
                    <tr>
                        <td valign="top">Image Left</td>
                        <td><?php echo $imageleft; ?></td>
                    </tr>
                    <tr>
                        <td valign="top">Description</td>
                        <td><?php echo $project->altleft; ?></td>
                    </tr>
                    <tr>
                        <td valign="top">Image Right Top</td>
                        <td><?php echo $imagerighttop; ?></td>
                    </tr>
                    <tr>
                        <td valign="top">Description</td>
                        <td><?php echo $project->altrighttop; ?></td>
                    </tr>
                    <tr>
                        <td valign="top">Image Right Bottom</td>
                        <td><?php echo $imagerightbottom; ?></td>
                    </tr>
                    <tr>
                        <td valign="top">Description</td>
                        <td><?php echo $project->altrightbottom; ?></td>
                    </tr>
                </table>
            </div>
            <br /><?php echo $link_back2 ?>&nbsp;<?php echo $link_back; ?>
        </div>
