import urllib.request
import urllib.parse
import os
import time
import ssl

ssl._create_default_https_context = ssl._create_unverified_context

images_to_generate = {
    'varikosel': 'A medical 3D illustration of male anatomy showing enlarged, varicose veins in the scrotum, professional and educational, clear lighting.',
    'asilama': 'A medical 3d render showing a thin catheter delivering sperm directly into the uterus, bright and clinical.',
    'embriyo-dondurma': 'A microscopic view of an embryo (blastocyst) surrounded by frost and ice crystals, glowing blue, cryogenic preservation concept.',
    'genetik-tup-bebek': 'A microscopic view of an embryo being biopsied with a micropipette, DNA helix glowing in the background, blue clinical tone.',
    'mikro-enjeksiyon': 'A highly detailed microscopic view of a single sperm being injected into an egg cell using a glass micropipette (ICSI procedure).',
    'rahim-dinlendirme': 'A calm, abstract conceptual medical image of a glowing healthy uterus enveloped in a soft, resting aura, blue and pink.',
    'sperm-dondurma': 'Microscopic sperm cells in a cryotube or surrounded by frost and ice crystals, blue cryogenic lighting.',
    'tup-bebek': 'A classic medical image of a human egg surrounded by sperm in a petri dish environment, glowing and hopeful, highly detailed 3D.',
    'yumurta-dondurma': 'A single glowing human egg cell (oocyte) surrounded by frost and ice crystals, cryopreservation concept, blue light.'
}

output_dir = '/Applications/XAMPP/xamppfiles/htdocs/konyatupbebek/uploads/tedaviler/'

opener = urllib.request.build_opener()
opener.addheaders = [('User-agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36')]
urllib.request.install_opener(opener)

for name, prompt in images_to_generate.items():
    print(f"Generating {name}...")
    encoded_prompt = urllib.parse.quote(prompt)
    url = f"https://image.pollinations.ai/prompt/{encoded_prompt}?width=800&height=600&nologo=true"
    
    try:
        urllib.request.urlretrieve(url, os.path.join(output_dir, f"{name}.png"))
        print(f"Saved {name}.png")
    except Exception as e:
        print(f"Failed to generate {name}: {e}")
    time.sleep(2)

print("Done!")
