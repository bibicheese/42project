/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   shit.c                                             :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: jmondino <jmondino@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/05/20 16:51:04 by jmondino          #+#    #+#             */
/*   Updated: 2019/05/29 19:37:48 by jmondino         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

#include "ft_ls.h"
/*
void	ft_pathless(DIR *pDir, struct dirent *pDirent, t_shit *pShit)
{
	pDir = opendir("./");			
  	ft_parse(pDir, pDirent, pShit);	
   	closedir (pDir);
	printf("\n");
}

void	ft_manypaths(DIR *pDir, struct dirent *pDirent, t_shit *pShit)
{
	int				i;
	int				j;

	i = pShit->index;
	j = i + 1;
    while (++i != pShit->ac)
    {
		if (j - (pShit->ac - 1) != 0)
			printf("%s:\n", pShit->av[i]);
		if ((pDir = opendir (pShit->av[i])) == NULL)
        {
			if (errno == ENOENT)
				printf ("ft_ls: %s: No such file or directory\n", pShit->av[i]);
			else
			{
				printf("%s\n", pShit->av[i]);
				continue;
			}
			exit(1);
        }
		ft_parse(pDir, pDirent, pShit);
        closedir (pDir);
        printf("\n");
        if (i + 1 != pShit->ac)
            printf("\n");
	}
}

char	**ft_lstotab(t_entries *lst, int i)
{
	char	**tab;
	int		j;

	j = 0;
	tab = (char **)malloc(sizeof(char *) * i + 1);
	while (lst)
	{
		tab[j] = (char *)malloc(sizeof(char) * ft_strlen(lst->name));
		tab[j] = lst->name;
		j++;
		lst = lst->next;
	}
	tab[j] = NULL;
	ft_asciiorder(tab);
	return tab;
}
*/
void	ft_asciiorder(char **tab)
{
	int		j;
	int		i;
	char	*tmp;

	j = 0;
	if (!(ft_strcmp(tab[0], "./ft_ls")))
		j++;
	while (tab[j])
	{
		i = j + 1;
		while (tab[i])
		{
			if (ft_strcmp(tab[i], tab[j]) < 0)
			{
				tmp = tab[i];
				tab[i] = tab[j];
				tab[j] = tmp;
			}
			i++;
		}
		j++;
	}
}
/*
void	ft_parse(DIR *pDir, struct dirent *pDirent, t_shit *pShit)
{
	t_entry		*lst;
	char		**tab;
	char		type;
	int			i;
	int			hidden;

	i = 0;
	hidden = checkoption(pShit->option, 'a');
	while ((pDirent = readdir(pDir)))
	{
		if (hidden == 0 && pDirent->d_name[0] == '.')
			continue;
		if (!(lst))
			lst = ft_newlst(pDirent->d_name, type);
		else
			ft_addlst(&lst, ft_newlst(pDirent->d_name, type));
		i++;
	}
	tab = ft_lstotab(lst, i);
	if (checkoption(pShit->option, 'r'))
		ft_revtab(tab);
	ft_afftab(tab);
	ft_memdel((void **)tab);
}

void	ft_afftab(char **tab)
{
	int		i = 0;
	int		length = 0;
	int		tmp;

	while (tab[i])
	{
		if (length < ft_strlen(tab[i]))
			length = ft_strlen(tab[i]);
		i++;
	}
	i = 0;
	while (tab[i])
	{
		printf("%s ", tab[i]);
		tmp = (length - ft_strlen(tab[i]));
		while (tmp != 0)
		{
			printf(" ");
			tmp--;
		}
		i++;
	}
}
*/