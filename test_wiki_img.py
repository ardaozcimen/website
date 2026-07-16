import requests

url = "https://en.wikipedia.org/w/api.php"
params = {
    "action": "query",
    "format": "json",
    "prop": "pageimages",
    "generator": "search",
    "gsrsearch": "microscope",
    "gsrlimit": 5,
    "pithumbsize": 800
}
try:
    r = requests.get(url, params=params)
    data = r.json()
    pages = data['query']['pages']
    for page_id, page in pages.items():
        if 'thumbnail' in page:
            print(page['title'], page['thumbnail']['source'])
except Exception as e:
    print(e)
