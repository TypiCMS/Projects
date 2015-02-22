<?php
use TypiCMS\Modules\Projects\Models\Project;

class ProjectsControllerTest extends TestCase
{

    public function testAdminIndex()
    {
        $response = $this->call('GET', 'admin/projects');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStoreFails()
    {
        $input = array('fr.title' => 'test', 'fr.slug' => '', 'category_id' => 1, 'tags' => '');
        $this->call('POST', 'admin/projects', $input);
        $this->assertRedirectedToRoute('admin.projects.create');
        $this->assertSessionHasErrors('fr.slug');
    }

    public function testStoreSuccess()
    {
        $object = new Project;
        $object->id = 1;
        Project::shouldReceive('create')->once()->andReturn($object);
        $input = array('fr.title' => 'test', 'fr.slug' => 'test', 'category_id' => 1, 'tags' => '');
        $this->call('POST', 'admin/projects', $input);
        $this->assertRedirectedToRoute('admin.projects.edit', array('id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new Project;
        $object->id = 1;
        Project::shouldReceive('create')->once()->andReturn($object);
        $input = array('fr.title' => 'test', 'fr.slug' => 'test', 'category_id' => 1, 'tags' => '', 'exit' => true);
        $this->call('POST', 'admin/projects', $input);
        $this->assertRedirectedToRoute('admin.projects.index');
    }

}
