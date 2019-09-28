import sys
import re
import os


def print_grid(grid, size):
    y = 0
    length = len(str(size * size - 1))
    c = len(grid)
    string = ""
    while y < c:
        x = 0
        while x < c:
            tmplen = len(str(grid[y][x]))
            tmpstr = str(grid[y][x]) + " "
            while tmplen < length:
                tmpstr += " "
                tmplen += 1
            string += tmpstr
            x += 1
        y += 1
        string += "\n"
    print(string)


def goal_grid(size):
    total_size = size * size
    ret = [[0 for x in range(size)]for y in range(size)]
    nb = 1
    snail = 0
    x = 0
    y = 0
    while nb < total_size:
        while x < (size - snail):
            ret[y][x] = nb
            x += 1
            nb += 1
        x -= 1
        y += 1
        while y < (size - snail):
            ret[y][x] = nb
            y += 1
            nb += 1
        y -= 1
        x -= 1
        if (nb == total_size):
            ret[y][x] = 0
            break
        while (x >= (0 + snail)):
            ret[y][x] = nb
            x -= 1
            nb += 1
        x += 1
        y -= 1
        snail += 1
        while (y >= (0 + snail)):
            ret[y][x] = nb
            y -= 1
            nb += 1
        y += 1
        x += 1
        if nb == total_size:
            ret[y][x] = 0
    return ret


def check_values(given_size, grid):
    grid_size = sum(len(x) for x in grid)
    if given_size < 2:
        print("Grid is too small")
        return 1
    if grid_size != given_size:
        print("Number missing")
        return 1
    return 0


def parse_file():
    content = []
    with open(sys.argv[1], "r") as ins:
        for line in ins:
            if line[0][0] != '#' and len(line) > 0:
                content.append(line.rstrip('\n'))
    given_size = int(content[0]) * int(content[0])
    content.pop(0)
    grid = [[int(number) for number in line.split(' ') if len(number) > 0]
            for line in content]
    if check_values(given_size, grid) != 0:
        return 1
    return grid


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


def main():
    if check_file() == 0:
       # grid = parse_file()
        grid = goal_grid(10)
        print_grid(grid, 10)
        return 0
    else:
        return 1


if __name__ == "__main__":
    main()
