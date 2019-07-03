/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   print_color.c                                      :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: jmondino <marvin@42.fr>                    +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/07/02 13:33:12 by jmondino          #+#    #+#             */
/*   Updated: 2019/07/02 17:02:54 by jmondino         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include "ft_ls.h"

void	print(t_entry *lst_st)
{
	t_entry		*browse;

	browse = lst_st;
	while (browse)
	{
		print_color(browse->name, browse->type, browse->rights);
		browse = browse->next;
	}
	if (lst_st)
		printf("\n");
}

void	print_color_l(char *entry, int type, char *rights)
{
	printf(RESET);
	if (S_ISDIR(type))
		printf(BOLDCYAN"%s", entry);
	if (S_ISREG(type))
	{
		if (ft_iscinstr(rights, 'x'))
			printf(RED"%s", entry);
		else
			printf(RESET"%s", entry);
	}
	if (S_ISLNK(type))
		printf(MAGENTA"%s", entry);
	if (S_ISBLK(type))
		printf(BLUEBLUE"%s", entry);
	if (S_ISCHR(type))
		printf(YELLOWBLUE"%s", entry);
	if (S_ISSOCK(type))
		printf(GREEN"%s", entry);
	if (S_ISFIFO(type))
		printf(BOLDCYANGREEN"%s", entry);
	printf(RESET);
}

void	print_color(char *entry, int type, char *rights)
{
	printf(RESET);
	if (S_ISDIR(type))
		printf(BOLDCYAN"%s  ", entry);
	if (S_ISREG(type))
	{
		if (ft_iscinstr(rights, 'x'))
			printf(RED"%s  ", entry);
		else
			printf(RESET"%s  ", entry);
	}
	if (S_ISLNK(type))
		printf(MAGENTA"%s  ", entry);
	if (S_ISBLK(type))
		printf(BLUEBLUE"%s  ", entry);
	if (S_ISCHR(type))
		printf(YELLOWBLUE"%s\033[0m  ", entry);
	if (S_ISSOCK(type))
		printf(GREEN"%s  ", entry);
	if (S_ISFIFO(type))
		printf(BOLDCYANGREEN"%s\033[0m  ", entry);
	printf(RESET);
}
