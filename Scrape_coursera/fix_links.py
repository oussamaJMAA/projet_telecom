import pandas as pd

pd.set_option('display.max_colwidth', None)


def fix_image_links(x):
    if x.find('png') != -1:
        k = x.partition(x[x.find('png') + 3])
    else:
        k = x.partition(x[x.find('jpg') + 3])
    return k[0]


with open('file.json', 'r') as f:
    df = pd.read_json(f)
print(df['image'])
print('****')
df['image'] = df['image'].apply(lambda x: fix_image_links(x))

print(df['image'])
df.to_json(r'file2.json', orient='records')
