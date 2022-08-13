import json
import os
import pymysql


con = pymysql.connect(host = '127.0.0.1', port = 3306, user = 'root', passwd = '', db = 'projet_telecom')
cursor = con.cursor()


for filename in os.listdir("formatted frensh json/json files"):
    with open("formatted frensh json/json files/{}".format(filename), mode='r') as file:
        data = json.load(file)
    for obj in data:

        cursor.execute("INSERT INTO quiz_questions "
                       "(question, choice_a, choice_b, choice_c, choice_d, correct_answer, explanation) "
                       "VALUES (%s,%s,%s,%s,%s,%s,%s)",
                       (obj["questions"],
                        obj["A choice"],
                        obj["B choice"],
                        obj["C choice"],
                        obj["D choice"],
                        obj["answers"],
                        obj["explanations"]))

con.commit()
con.close()
