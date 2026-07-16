import requests

url = "https://commons.wikimedia.org/w/api.php"
params = {
    "action": "query",
    "format": "json",
    "prop": "imageinfo",
    "generator": "search",
    "gsrsearch": "filetype:bitmap in vitro fertilisation",
    "gsrlimit": 5,
    "iiprop": "url"
}
r = requests.get(url, params=params, headers={"User-Agent": "AntigravityIDE/1.0"})
data = r.json()
if 'query' in data and 'pages' in data['query']:
    for pid, page in data['query']['pages'].items():
        if 'imageinfo' in page:
            print(page['imageinfo'][0]['url'])
