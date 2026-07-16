import os
from PIL import Image

dir_path = "/Applications/XAMPP/xamppfiles/htdocs/konyatupbebek/uploads/tedaviler"

for filename in os.listdir(dir_path):
    if filename.endswith(".png"):
        file_path = os.path.join(dir_path, filename)
        img = Image.open(file_path)
        webp_filename = filename[:-4] + ".webp"
        webp_path = os.path.join(dir_path, webp_filename)
        
        # Save as webp with 80% quality
        img.save(webp_path, "WEBP", quality=80)
        
        # Remove the original png
        os.remove(file_path)
        print(f"Converted {filename} to {webp_filename}")
