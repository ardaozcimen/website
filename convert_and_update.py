import os
import sqlite3
from PIL import Image
import glob

# 1. Convert images
src_dir = '/Users/onurardaozcimen/.gemini/antigravity-ide/brain/18aa62a9-8685-4e5b-b464-b97ae80ac454/'
dest_dir = 'uploads/blogs/'
os.makedirs(dest_dir, exist_ok=True)

png_files = sorted(glob.glob(src_dir + '*.png'))
webp_paths = []

for png in png_files:
    # get base name without timestamp
    base = os.path.basename(png)
    name = base.split('_17')[0]  # remove timestamp part
    
    webp_name = name + '.webp'
    webp_path = os.path.join(dest_dir, webp_name)
    
    # open and convert
    try:
        im = Image.open(png)
        im.save(webp_path, 'WEBP', quality=85)
        webp_paths.append(webp_path)
    except Exception as e:
        print(f"Error converting {png}: {e}")

# 2. Update database
if webp_paths:
    db_path = 'db/konyatupbebek.db'
    conn = sqlite3.connect(db_path)
    cursor = conn.cursor()
    
    # get the latest 15 blogs
    cursor.execute("SELECT id FROM blogs ORDER BY id DESC LIMIT 15")
    rows = cursor.fetchall()
    
    for i, row in enumerate(rows):
        if i < len(webp_paths):
            blog_id = row[0]
            img_url = webp_paths[i]
            cursor.execute("UPDATE blogs SET image_url = ? WHERE id = ?", (img_url, blog_id))
    
    conn.commit()
    conn.close()
    print(f"Successfully converted {len(webp_paths)} images and updated DB.")
else:
    print("No images found to process.")
