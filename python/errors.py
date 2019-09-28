import sys
import os

def check_values(given_size, grid):
    grid_size = sum(len(x) for x in grid)
    if given_size < 2:
        print("Grid is too small")
        return 1
    if grid_size != given_size:
        print("Number missing")
        return 1
    return 0

def check_file():
    if os.path.isfile(sys.argv[1]) == 0:
        print("File doesn't exist")
        return (1)
    if sys.argv[1].endswith('.txt') == 0:
        print("Invalid file extension")
        return (1)
    if os.stat(sys.argv[1]).st_size == 0:
        print("File is empty")
        return (1)
    return 0