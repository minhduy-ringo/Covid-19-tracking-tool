# Support looking for tracking file crawl by corona spider

import glob
import os

dir_name = os.path.dirname(__file__)
tracking_dir = os.path.join(dir_name, 'corona_tracking/')

def FindByDate(date):
    """
        Find a file in tracking folder by input date and return an absolute path to the file\n
        FindByDate(date: string)\n
        Date format: ddMmm Ex: 06Jun
    """
    os.chdir(tracking_dir)
    try:
        file = glob.glob('*' + date + '*')
        fpath = tracking_dir + file[0]
    except IndexError:
        print("File not found!")
    return fpath

def AllFiles():
    """
        Return a list contains absolute path to all the files in tracking folder\n
    """
    os.chdir(tracking_dir)
    all_files = glob.glob('*.csv')
    try:
        fpath = []
        for file in all_files:
            file = tracking_dir + file
            fpath.append(file)
    except IndexError:
        print("No tracking file")
    return fpath