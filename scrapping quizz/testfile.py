from scrapping import QuizScrapper
import os

if __name__ == "__main__":
    for file in os.listdir("html files"):
        QuizScrapper("html files/{}".format(os.fsdecode(file)))
