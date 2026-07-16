import os
import re

directory = "/Applications/XAMPP/xamppfiles/htdocs/konyatupbebek"

for root, dirs, files in os.walk(directory):
    if "admin" in root or "db" in root:
        continue
    for file in files:
        if file.endswith(".php"):
            path = os.path.join(root, file)
            with open(path, "r", encoding="utf-8") as f:
                content = f.read()
            
            # Replace href="index" with href="<?= BASE_URL ?>"
            new_content = re.sub(r'href="index"', r'href="<?= BASE_URL ?>"', content)
            new_content = re.sub(r'href="<\?= BASE_URL \?>index"', r'href="<?= BASE_URL ?>"', new_content)
            new_content = re.sub(r'href="<\?= BASE_URL \?>index#', r'href="<?= BASE_URL ?>#', new_content)
            
            if new_content != content:
                with open(path, "w", encoding="utf-8") as f:
                    f.write(new_content)
                print(f"Updated index links in {path}")
