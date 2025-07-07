# Snippets for vtiger developers

Code snippets are designed to be reused in various parts of a project or even across different projects.
The snippets provided here mainly specific to vtiger CE

## Timer

You can add this time anywhere in vtiger layout. This example shows the top right in the header, just before Calendar / Report icons

1. Open __layouts/trillium/modules/Vtiger/partials/Topbar.tpl__
2. Add below js code at the bottom (alternatively you can put it in a common .js file and include at the top)

```
     <script>
                             function showClock() {
                                  const now = new Date();
                                  const hours = now.getHours().toString().padStart(2, '0');
                                  const minutes = now.getMinutes().toString().padStart(2,  
                                 '0');
                                  const seconds = now.getSeconds().toString().padStart(2, '0');
                                
                                  const  
                                 timeString = hours + ':' + minutes + ':' + seconds;
                                  document.getElementById('clock').textContent = timeString;
                                }
                                setInterval(showClock,  
                                 1000);
       </script>

```

3. Now put a place holder as first plance of the ```<ul class="nav navbar-nav">```

```
       <li>
            <div class="dropdown pull-left">
                <div id="clock" class="dropdown-toggle" style="padding-top:10px;"></div>
            </div>
					       
      </li>
```

4. Now login to vtiger and reload the page. The timer will be showns in top bar
