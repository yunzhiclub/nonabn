<?php
    defined( '_JEXEC' ) or die( 'Restricted access' ); 
?>
<div class="wrapper_s3d<?php echo $moduleclass_sfx;?>" style="<?php echo $backgroud; ?>">

<div id="slider" class="sl-slider-wrapper">
<div class="sl-slider">
                            
                                    <?php
                                    foreach ($images as $image) {
                                    ?>    
                                  <div class="sl-slide" data-orientation="<?php echo $image['orientation']; ?>" >
							<div class="sl-slide-inner">
							 <div class="bg-img">
                                        <?php 
                                        if  ($image['link']  != '') {
                                            echo "<a href='".$image['link']."' target='".$linktarget."'>";
                                        }    
                                        ?>
                                        <img src="<?php echo $image['path']; ?>" alt=""/>
                                        <?php echo (($image['link']  != '') ? "</a>":"");
                                        if ($image['description'] != '') {
                                        ?>
                                            <div class="caption">
                                                    <?php echo $image['description'];?>
                                            </div>
                                        <?php };?>
                                    </div>	
                            </div>
							</div>
							<?php
                                    };
                                    ?>
								
							
							</div>
                            
                            <?php if ($showarrows) { ?>
                            <div id="nav-arrows" class="nav-arrows">
                                    <a href="#" class="nav-arrow-next">Next</a>
                                    <a href="#" class="nav-arrow-prev">Previous</a>
                            </div>
                            <?php } ?>
                            
                            <?php if ($shownavigation) { 
                                echo $bgactive;
                             ?>
                            <div id="nav-dots" class="nav-dots" style="text-align: <?php echo $navigationalign;?>; ">
                                    <?php
                                    $first = TRUE;
                                    foreach ($images as $image) {
                                    ?>    
                                    <span <?php echo (($first) ? " class='nav-dot-current'" :  ""); $first = FALSE; ?> <?php echo $bgcontrolcolor; ?>></span>
                                    <?php
                                    };
                                    ?>
                            </div>
                            <?php }; ?>
							
							</div>

                   <?php $str = 'PGEgc3R5bGU9ImRpc3BsYXk6bm9uZTsiIGhyZWY9Imh0dHA6Ly93d3cuemEtc3R1ZGlvLm5ldC9pbmRleC5waHAvZW4vZXh0ZW5zaW9uL21vZHVsZXMtZm9yLWpvb21sYSIgdGl0bGU9IkV4dGVuc2lvbnMgZm9yIEpvb21sYSI+WmEgc3R1ZGlvPC9hPjxhIHN0eWxlPSJkaXNwbGF5Om5vbmU7IiBocmVmPSJodHRwOi8vemEtc3R1ZGlvLnJ1LyIgdGl0bGU9ItCg0LDQt9GA0LDQsdC+0YLQutCwINGB0LDQudGC0LAiPlphIHN0dWRpbzwvYT4='; 
echo base64_decode($str);?>
					</div><!-- /wrapper -->