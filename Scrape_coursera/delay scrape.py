from selenium import webdriver
import os

from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.common.by import By

import pandas as pd


roaming = os.getenv('APPDATA')
app_data = os.path.dirname(roaming)

DRIVER_PATH = app_data +"\Local\Temp\Rar$EXa16172.25977\chromedriver.exe"
base = "https://www.coursera.org"

options = Options()
options.headless = True
options.add_argument("--window-size=1920,1200")

course_names  = []
course_images = []
course_skills = []
course_links  = []
course_rates  = []

driver = webdriver.Chrome(options=options, executable_path=DRIVER_PATH)
# driver = webdriver.Chrome(executable_path=DRIVER_PATH)

for _ in range(1, 9):
    url = "https://www.coursera.org/search?query=cybersecurity&page={}&index=prod_all_launched_products_term_optimization".format(_)
    driver.get(url)
    el = WebDriverWait(driver, timeout=10).until(lambda d: d.find_element(By.TAG_NAME, 'main')
                                                 .find_elements(By.TAG_NAME, 'li'))

    for i in el:
        card = i.find_element(By.TAG_NAME, 'a')
        try:
            course_names.append(card.find_element(By.TAG_NAME, 'h2').text)
            course_images.append(card.find_element(By.TAG_NAME, 'img').get_attribute('src'))
            course_skills.append(card.find_element(By.TAG_NAME, 'p').text)
            course_links.append(str(card.get_attribute('href')))

            p_list = [x.text for x in card.find_elements(By.TAG_NAME, 'p')]
            try:
                int(min(p_list, key=len)[0])
            except:
                course_rates.append(None)
            else:
                course_rates.append(min(p_list, key=len))
        except:
            lengths = [course_rates, course_names, course_images, course_links, course_skills]

            for i in range(len(lengths) - 1):
                if len(lengths[0]) == len(lengths[1]) and \
                        len(lengths[0]) == len(lengths[2]) and \
                        len(lengths[0]) == len(lengths[3]) and \
                        len(lengths[0]) == len(lengths[4]):
                    print(lengths, ' ye')
                    break
                else:
                    print(lengths.index(max(lengths, key=len)))
                    lengths[lengths.index(max(lengths, key=len))].pop(-1)
            break

data = {'name': course_names,
        'image': course_images,
        'skill': course_skills,
        'link': course_links,
        'rate': course_rates}

df = pd.DataFrame(data)
print(df)

df.to_json(r'file.json', orient='records')
