Link assets
===========

This is little CLI script for creating symlinks from configuration 

I'm using it accross different projects when I have to often create few
different symlinks just to get some things to work

Run it
---------------------

1. Download link-assets.php script
2. Place it somewhere in your project (for. ex. inside "scripts" or "bin" folder) 
3. Change $baseAssetsPath (at line 5) and $pathsMapping (at line 10) to meet your needs
4. Give it "execution" permission using command:
``` bash
sudo chmod +x ./bin/link-assets.php
```
5. Run it: 
``` bash
./bin/link-assets.php
```

Dependencies
---------------------

To run this you need to have php5-cli installed (php available in terminal).
