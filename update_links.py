import os
import re

directory = "/Applications/XAMPP/xamppfiles/htdocs/konyatupbebek"
target_pages = ['index', 'hakkimizda', 'iletisim', 'blog', 'bebeklerimiz', 'blog-detay', 'detay']

for root, dirs, files in os.walk(directory):
    if "admin" in root or "db" in root:
        continue
    for file in files:
        if file.endswith(".php"):
            path = os.path.join(root, file)
            with open(path, "r", encoding="utf-8") as f:
                content = f.read()
            
            new_content = content
            for page in target_pages:
                # Match href="...page.php..." or href='...page.php...'
                new_content = re.sub(rf"(href=[\"'].*?{page})\.php([?\"'#])", r"\1\2", new_content)
                # Match action="...page.php"
                new_content = re.sub(rf"(action=[\"'].*?{page})\.php([?\"'])", r"\1\2", new_content)
            
            if new_content != content:
                with open(path, "w", encoding="utf-8") as f:
                    f.write(new_content)
                print(f"Updated {path}")
