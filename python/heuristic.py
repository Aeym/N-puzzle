from grid import goal_grid

def manhattan_state(grid, size):
    y = 0
    total = 0
    for y in range(size):
        x = 0       
        for x in range(size):
            if grid[y][x] != 0:
                tmp = findingoal(grid[y][x], size)            
                total += manhattan(tmp[0], tmp[1], x, y)
    return total
 
def manhattan(xGoal, yGoal, xActual, yActual):
    return abs(xGoal - xActual) + abs(yGoal - yActual)

def findingoal(num, size):
    y = 0
    grid = goal_grid(size)
    tmp = [0, 0]
    for y in range(size):
        x = 0
        for x in range(size):
            if grid[y][x] == num:
                tmp[0] = x
                tmp[1] = y
                return (tmp)
    return 0
