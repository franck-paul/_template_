# _template_

Dotclear 2 template plugin

## Script to migrate old code to new one (using src and namespaces)

```language-sh
#!/bin/sh

# Check 1st parameter (module name = directory)
if [ -z "$1" ]; then
  echo "You must give the module name = module directory"
  exit 1
fi

# Check module existance
if [ ! -d "$1" ]; then
  echo "The module $1 does not exists"
  exit 1
fi

MODULE="$1"

# Check module src subfolder
if [ ! -d "$MODULE/src" ]; then
  mkdir "$MODULE/src"
fi

MODEL="_template_"
update_ns()
{
  perl -i -pe"s/_template_/$MODULE/g" "$1"
}
make_my()
{
  if [ ! -f "$MODULE/src/My.php" ]; then
    cp "$MODEL/src/My.php" "$MODULE/src/My.php"
    update_ns "$MODULE/src/My.php"
  fi
}
make_uninstall()
{
  if [ ! -f "$MODULE/src/Uninstall.php" ]; then
    cp "$MODEL/src/Uninstall.php" "$MODULE/src/Uninstall.php"
    update_ns "$MODULE/src/Uninstall.php"
  fi
}
make_src()
{
  if [ -f "$MODULE/$1.php" ]; then
    if [ ! -f "$MODULE/src/$2.php" ]; then
      cp "$MODEL/src/$2.php" "$MODULE/src/$2.php"
      update_ns "$MODULE/src/$2.php"
      # Add a separator between new and old code
      {
        echo ""
        echo "// --- old code below ---"
        echo ""
      } >> "$MODULE/src/$2.php"
      # Add old code at the end
      tail +2 "$MODULE/$1.php" >> "$MODULE/src/$2.php"
    fi
  fi
}

# Add a src/My.php
make_my

# Move existing code to src
make_src _install Install
make_src _prepend Prepend
make_src _admin Backend
make_src _public Frontend
make_src _config Config
make_src index Manage
make_src _widgets Widgets

# Add a src/Uninstall.php
make_uninstall
```

The `_template_` plugin and others should be in a main folder where the above script will be copy in.

Do `chmod +x do_src.sh` to allow execution

Do `./do_src.sh module_folder_name` to run the script for the corresponding module.

Example:

`AllPlugins` (main folder)  
|- `_template_` (this repo)  
|- `myPlugin` (a module to update)  
|- `myOtherPlugin` (another module to update)

Do:

- `cd AllPlugins`
- `./do_src.sh myPlugin`
- `./do_src.sh myOtherPlugin`

See <https://open-time.net/2023/05/10/Modele-de-plugin> for explanations (in French)

