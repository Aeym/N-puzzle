import sys
from errors import check_values

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

def get_grid():
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