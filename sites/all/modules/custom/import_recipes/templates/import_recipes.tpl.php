<?php echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n" ?>
<entities> 
 <?php
 	foreach($nodes as $node){
              print "<recipe>";
		print "<name>".$node['name']."</name>";
		print "<url>".$node['url']."</url>";		
		print "<type>".$node['type']."</type>";
		foreach ($node['ingredients'] as $ingredient){
			print '<ingredient>';
				print "<name>".$ingredient['name']."</name>";
				print "<type>".$ingredient['unit_key']."</type>";
				print "<value>".$ingredient['quantity']."</value>";
			print '</ingredient>';
		}
		
		foreach ($node['instructions'] as $instruction){
		    print "<instruction>";
		    print check_plain($instruction);
		    print "</instruction>";
		}
		
              print "</recipe>";
	}
  ?>
</entities> 
