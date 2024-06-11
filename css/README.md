To run grunt compileing, move into 'cd' into the folder where you have the .less file.
For vtiger, is

_layouts/v7/skins/vtiger/style.less_

You may put the above Gruntfile.js into above `vtiger` folder. Alternatively you may put into skins folder directly by changing the relative path of the 'files' section.

Install grunt and link to your project, 

``npm install --save-dev grunt grunt-cli grunt-contrib-less``

Then install grunt CLI (if not already installed)

``sudo npm install -g grunt-cli``

Then liftoff extension

``npm install liftoff --save-dev``

Then clear cache

``npm cache clean --force``

Further in the Gruntfile.js, you may add / remove .css files under less.development.files section

Once above setup is done, you can run 

``grunt``  to process LESS 

Or

``grunt --force`` to skip errors


