from bs4 import BeautifulSoup
import requests
import pandas as pd

website = "https://www.coursera.org/courses?query=cybersecurity"
response = requests.get(website)

print("response status:", response.status_code)

soup = BeautifulSoup(response.content, 'html.parser')
# results
results = soup.find_all('li', class_='cds-63 css-0 cds-65 cds-grid-item cds-110 cds-118 cds-130')
print(len(results))


def fix_image_links(x):
    if x.find('png') != -1:
        k = x.partition(x[x.find('png') + 3])
    else:
        k = x.partition(x[x.find('jpg') + 3])
    return k[0]


course_names = []
course_images = []
course_skills = []
course_links = []
course_rates = []

for item in results:
    course_names.append(item.h2.text)
    course_images.append(fix_image_links(item.img['src']))
    course_skills.append(item.p.text)
    course_links.append("https://www.coursera.org" + item.div.a['href'])
    for i in item.find_all('p', class_='cds-33 css-zl0kzj cds-35'):
        course_rates.append(i.text)

print(course_rates)

data = {'name': course_names, 'image': course_images, 'skill': course_skills, 'link': course_links}

df = pd.DataFrame(data)

# df.to_json(r'json files\file.json', orient='records')
