from grid import get_grid, goal_grid, print_grid
from errors import check_file

def main():
    if check_file() == 0:
        grid2 = get_grid()
        grid = goal_grid(10)
        print_grid(grid, 10)
        return 0
    else:
        return 1


if __name__ == "__main__":
    main()
