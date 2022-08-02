
from bs4 import BeautifulSoup
import pandas as pd


class QuizScrapper:
    def __init__(self, fileName):
        self.dataLists = self.initDF()
        self.parseData(fileName)

    def initDF(self):
        questions = []
        choiceA = []
        choiceB = []
        choiceC = []
        choiceD = []
        answers = []
        explanations = []
        return [questions, choiceA, choiceB, choiceC, choiceD, answers, explanations]

    def initSoup(self, fileName):
        with open(fileName, 'r', encoding="utf-8") as doc:
            return BeautifulSoup(doc, "html.parser")

    def parseData(self, fileName):
        Qs = self.initSoup(fileName).find("div", class_="entry-content").find_all('p', recursive=True, limit=36)
        Qs.remove(Qs[0])
        for Q in Qs:
            Q.find("span").decompose()
            for br in Q.find_all("br"):
                br.decompose()
            splits = Q.text.split('\n')
            for i in range(len(splits) - 1):
                self.dataLists[i].append(splits[i])

        As = self.initSoup(fileName).find_all("div", class_="collapseomatic_content", recursive=True, limit=35)
        for A in As:
            splits = A.text.split('\n')
            self.dataLists[5].append(splits[0])
            self.dataLists[6].append(splits[1])

        Data = {"questions": self.dataLists[0],
                "A choice": self.dataLists[1],
                "B choice": self.dataLists[2],
                "C choice": self.dataLists[3],
                "D choice": self.dataLists[4],
                "answers": self.dataLists[5],
                "explanations": self.dataLists[6]}
        df = pd.DataFrame(Data)
        df.to_json("json files/{}.json".format(fileName), orient='records')
