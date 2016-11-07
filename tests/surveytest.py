from selenium import webdriver
from selenium.webdriver.common.keys import Keys
import os

params = [[1,0,0], [2,0,1], [3,1,0], [4,1,1]]
testpath = os.path.dirname(os.path.abspath(__file__))
rootpath = testpath.strip('/tests')

def getStartUrl(idx = 0):
    return 'file:///'+rootpath+'/index.html#?i=%s&ru=%s&rh=%s' % (params[idx][0], params[idx][1], params[idx][2], )

def getFileUrl(htmlname):
    return 'file:///'+rootpath+'/'+htmlname

driver = webdriver.Chrome(testpath+'/chromedriver')

for i in range(0,4):
    print i

driver.get(getStartUrl(0))
button = driver.find_element_by_tag_name('button')
button.click().perform()